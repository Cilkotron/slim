<?php

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use App\Controller\FriendController;


require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/FriendController.php';
require_once __DIR__ . '/../tests/FriendControllerTest.php';

// Create Container
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/definitions.php');
$container = $containerBuilder->build();

// Instantiate App
AppFactory::setContainer($container);
$app =  AppFactory::create();


$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, false);


// Register routes
$app->get('/friends', FriendController::class  . ':getAllFriends');
$app->get('/friends/{id}', FriendController::class . ':getFriend');
$app->post('/friends', FriendController::class . ':createFriend');
$app->put('/friends/{id}', FriendController::class . ':updateFriend');
$app->delete('/friends/{id}', FriendController::class . 'deleteFriend');


$app->run();
