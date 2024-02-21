<?php

declare(strict_types=1);


use App\Auth;
use App\Contracts\SessionInterface;
use App\Csrf;

use Slim\App;
use App\Lookups;


use App\Session;
use Monolog\Logger;
use Slim\Csrf\Guard;
use Slim\Views\Twig;
use App\Models\Model;


use DI\ContainerBuilder;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;

use App\Contracts\AuthInterface;
use App\Contracts\ModelInterface;
use App\DataObjects\SessionConfig;
use Monolog\Handler\StreamHandler;
use App\Contracts\LookupsInterface;
use Monolog\Processor\UidProcessor;
use App\Services\UserProviderService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use App\Application\Settings\SettingsInterface;
use App\Contracts\UserProviderServiceInterface;
use App\RequestValidators\RequestValidatorFactory;
use App\Contracts\RequestValidatorFactoryInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        // Instantiate the app
        App::class => function (ContainerInterface $container) {
            AppFactory::setContainer($container);
            $middleware = require __DIR__ . '/../app/middleware.php';
            $routes = require __DIR__ . '/../app/routes.php';
            $app = AppFactory::create();

            // Register middleware
            $middleware($app);
            // Register routes
            $routes($app);

            return $app;
        },

        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },


        Twig::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $twigSettings   = $settings->get('twig');

            $options = [];
            if ($twigSettings['cache']) {
                $options = [
                    'cache' => $twigSettings['path_cache']
                ];
            }
            return Twig::create($twigSettings['path_templates'], $options);
        },

        PDO::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $dbSettings = $settings->get('db');


            $driver     = $dbSettings['driver'];
            $host       = $dbSettings['host'];
            $port       = $dbSettings['port'];
            $dbname     = $dbSettings['database'];
            $username   = $dbSettings['username'];
            $password   = $dbSettings['password'];
            //$charset    = $dbSettings['charset'];



            $dsn = "$driver:host=$host;port=$port;dbname=$dbname";

            $options       = [
                PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, //make the default fetch be an associative object
                //\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, //make the default fetch be an associative array
            ];

            return new PDO($dsn, $username, $password, $options);
        },
        ModelInterface::class => fn (ContainerInterface $container) => $container->get(Model::class),

        SessionInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $sessionSettings = $settings->get('session');
            $sessionConfig = new SessionConfig(
                $sessionSettings['name'],
                $sessionSettings['flash_name'],
                $sessionSettings['secure'],
                $sessionSettings['httponly'],
                $sessionSettings['samesite'],
                //SameSite::from($sessionSettings['samesite'])
            );
            return new Session($sessionConfig);
        },

        LookupsInterface::class => function () {
            $lookups = require __DIR__ . '/../app/lookups.php';
            return new Lookups($lookups);
        },

        ResponseFactoryInterface::class => fn (App $app) =>  $app->getResponseFactory(),



        RequestValidatorFactoryInterface::class => fn (ContainerInterface $container) => $container->get(
            RequestValidatorFactory::class
        ),

        AuthInterface::class => fn (ContainerInterface $container) => $container->get(Auth::class),
        UserProviderServiceInterface::class => fn (ContainerInterface $container) => $container->get(UserProviderService::class),

        'csrf' => fn (ResponseFactoryInterface $responseFactory, Csrf $csrf) => new Guard(
            $responseFactory,
            failureHandler: $csrf->failureHandler(),
            persistentTokenMode: true
        ),
    ]);
};
