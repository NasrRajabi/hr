<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],

                'twig' => [
                    'path_templates' => __DIR__ . '/../src/Views',
                    'path_cache' => __DIR__ . '/../var/cache/views',
                    'cache'     => false, // Should be set to true in production
                ],
                "db" =>
                [
                    'driver'   => 'pgsql',
                    'host'     => '192.168.0.2',
                    'port'     =>  5432,
                    'database' => 'hr',
                    'username' => 'root',
                    'password' => 'root',
                    'prefix'   => '',
                    'charset'  => 'utf8mb4',
                    'schema'   => 'public',
                ],
                "session" => [
                    'name'       => /*$appSnakeName .*/ 'HR_session',
                    'flash_name' => /*$appSnakeName . */'HR_flash',
                    'secure'     => true,
                    'httponly'   => true,
                    'samesite'   => 'lax',
                ],
            ]);
        }
    ]);
};
