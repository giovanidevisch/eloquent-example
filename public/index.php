<?php

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;

require '../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$dependencies = require('../src/dependencies.php');
$dependencies($containerBuilder);

$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

$routes = require '../src/routes.php';
$routes($app);

$app->getContainer()->get('Illuminate\Database\Capsule\Manager');

$app->run();
