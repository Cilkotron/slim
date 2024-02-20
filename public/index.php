<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory; 


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';


$app = AppFactory::create();

$app->addRoutingMiddleware();


$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello");
    return $response;
});


require __DIR__ . '/../routes/friends.php';


$app->run(); 