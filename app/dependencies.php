<?php
declare(strict_types=1);

use App\Order\Application\OrderListUseCase;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Infrastructure\Persistence\MysqlOrderRepository;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions(
        [
            LoggerInterface::class => function (ContainerInterface $container) {
                $settings = $container->get('settings');

                $loggerSettings = $settings['logger'];
                $logger = new Logger($loggerSettings['name']);

                $processor = new UidProcessor();
                $logger->pushProcessor($processor);

                $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
                $logger->pushHandler($handler);

                return $logger;
            },

            PDO::class => function (ContainerInterface $container) {
                $driver = $container->get('settings')['database']['driver'];
                $database = $container->get('settings')['database'][$driver];
                $databaseFlags = $container->get('settings')['database']['flags'];

                $host = $database['host'];
                $dbname = $database['database'];
                $username = $database['username'];
                $password = $database['password'];
                $charset = $database['charset'];
                $flags = $databaseFlags;
                $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

                return new PDO($dsn, $username, $password, $flags);
            },
        ]
    );
};
