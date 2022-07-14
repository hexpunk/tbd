<?php

declare(strict_types=1);

use App\Handlers\HttpErrorHandler;
use App\Handlers\ShutdownHandler;
use App\ResponseEmitter;
use App\Settings\AppSettings;
use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Psr\Log\LoggerInterface;
use Slim\Factory\ServerRequestCreatorFactory;

// TODO: Use an environment variable or something for this path.
const __BASE__ = __DIR__ . '/../..';

require __BASE__ . '/vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// TODO: Use an environment variable or something to switch this.
/** @phpstan-ignore-next-line */
if (false) { // Should be set to true in production
    // TODO: Use an environment variable or something for this path.
    $containerBuilder->enableCompilation(__BASE__ . '/var/cache');
    // TODO: Make sure this cache is busted on deploy.
}

// Set up settings
$settings = require __BASE__ . '/bootstrap/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __BASE__ . '/bootstrap/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
$app = Bridge::create($container);

// Set base path
preg_match('/.*\/public(\/.*)/', __DIR__, $basePathMatch);
if (isset($basePathMatch[1])) {
    $app->setBasePath($basePathMatch[1]);
}

$callableResolver = $app->getCallableResolver();

// Register middleware
$middleware = require __BASE__ . '/bootstrap/middleware.php';
$middleware($app);

// Register routes
$routes = require __BASE__ . '/bootstrap/routes.php';
$routes($app);

/** @var AppSettings */
$settings = $container->get(AppSettings::class);

/** @var LoggerInterface */
$logger = $container->get(LoggerInterface::class);

$displayErrorDetails = $settings->displayErrorDetails;
$logError = $settings->logError;
$logErrorDetails = $settings->logErrorDetails;

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory, $logger);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler(
    $request,
    $errorHandler,
    $displayErrorDetails,
    $logger,
);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails, $logger);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
