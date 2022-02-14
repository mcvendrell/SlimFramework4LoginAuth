<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

use Slim\Exception\HttpNotFoundException;
//use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface;

require __DIR__ . '/../../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/dependencies.php';
$dependencies($containerBuilder);

// Create a Container using PHP-DI to manage containers (containers are like little snipets or functions returning something ready to all the app life)
$container = $containerBuilder->build();

// Add container to AppFactory before create App
AppFactory::setContainer($container);

// Instantiate app
$app = AppFactory::create();

// Setup a supersimple auth checker, intercepting http calls with this middleware and checking that only allowed routes can be navigated without auth
$loggedInMiddleware = function($request, $handler): ResponseInterface {
    $routeContext = RouteContext::fromRequest($request);
    $route = $routeContext->getRoute();

    if (empty($route)) { throw new HttpNotFoundException($request, $response); }

    $routeName = $route->getName();

    // Define routes that user does not have to be logged in with. All other routes, the user needs to be logged in with.
    // Names for routes must be defined in routes.php with ->setName() for each one.
    $publicRoutesArray = array('root', 'apiLogin');

    //var_dump("User ID: ".(empty($_SESSION['user']) ? ' none' : $_SESSION['user']));
    if (empty($_SESSION['user']) && (!in_array($routeName, $publicRoutesArray))) {
        // Create a redirect for a named route
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('root');

        $response = new \Slim\Psr7\Response();

        return $response->withHeader('Location', $url)->withStatus(302);
    } else {
        $response = $handler->handle($request);

        return $response;
    }
};
$app->add($loggedInMiddleware);

// Add Routing Middleware (needed to use RouteContext previously in middleware, for example)
$app->addRoutingMiddleware();

// Register routes
$routes = require __DIR__ . '/routes.php';
$routes($app);

$errorSetting = $app->getContainer()->get('settings')['displayErrorDetails'];
/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> SHOULD BE SET TO FALSE IN PRODUCTION
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$app->addErrorMiddleware($errorSetting, true, true);

$app->run();
