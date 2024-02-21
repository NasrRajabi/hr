<?php

declare(strict_types=1);


use Slim\App;
use DI\ContainerBuilder;
use App\Application\Handlers\ShutdownHandler;
use Slim\Factory\ServerRequestCreatorFactory;
use App\Application\Handlers\HttpErrorHandler;
use App\Application\Settings\SettingsInterface;
use App\Application\ResponseEmitter\ResponseEmitter;

require __DIR__ . '/../vendor/autoload.php';


// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

//$containerBuilder->enableCompilation(__DIR__ . '/../var/cache');  #### (Should be uncomment in production)

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up lookups
// $lookups = require __DIR__ . '/../app/lookups.php';
// $lookups($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();


$callableResolver = $container->get(App::class)->getCallableResolver();









/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $container->get(App::class)->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$container->get(App::class)->addRoutingMiddleware();

// Add Body Parsing Middleware
$container->get(App::class)->addBodyParsingMiddleware();




// Add Error Middleware
$errorMiddleware = $container->get(App::class)->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App & Emit Response
$response = $container->get(App::class)->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);

