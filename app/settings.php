<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions(
        [
            'settings' => [
                'displayErrorDetails' => (bool)$_ENV['DEBUG'],
                'logger'              => [
                    'name'  => 'slim-app',
                    'path'  => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'database'            => [
                    'driver' => $_ENV['DB_DRIVER'],
                    'mysql'  => [
                        'driver'    => $_ENV['DB_DRIVER'],
                        'host'      => $_ENV['DB_HOST'],
                        'database'  => $_ENV['DB_NAME'],
                        'username'  => $_ENV['DB_USERNAME'],
                        'password'  => $_ENV['DB_PASSWORD'],
                        'charset'   => 'utf8mb4',
                        'collation' => 'utf8mb4_unicode_ci',
                    ],
                    'flags'  => [
                        // Turn off persistent connections
                        PDO::ATTR_PERSISTENT         => false,
                        // Enable exceptions
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        // Emulate prepared statements
                        PDO::ATTR_EMULATE_PREPARES   => true,
                        // Set default fetch mode to array
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        // Set character set
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
                    ],
                ],
            ]
        ]
    );
};
