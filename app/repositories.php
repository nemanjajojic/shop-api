<?php
declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Infrastructure\Persistence\MysqlOrderRepository;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions(
        [
            OrderRepository::class => function (ContainerInterface $container) {
                return new MysqlOrderRepository($container->get(PDO::class));
            },
        ]
    );
};
