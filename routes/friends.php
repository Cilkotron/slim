<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Get all 
$app->get('/friends/all', function (Request $request, Response $response) {
    $sql = "SELECT * FROM friends";
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $friends = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $response->getBody()->write(json_encode($friends));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

//Get single
$getFriend = $app->get('/friends/{id}', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM friends WHERE id = $id";
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $friend = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        $response->getBody()->write(json_encode($friend));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

// Create 
$app->post('/friends/add', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $email = $data['email'];
    $display_name = $data['display_name'];
    $phone = $data['phone'];

    $sql = "INSERT INTO friends (email, display_name, phone) VALUE (:email, :display_name, :phone)";

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':display_name', $display_name);
        $stmt->bindParam(':phone', $phone);
        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

// Update one 
$app->put('/friends/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id']; 
    $data = $request->getParsedBody();
    $email = $data['email'];
    $display_name = $data['display_name'];
    $phone = $data['phone'];

    $sql = "UPDATE friends SET email=?, display_name=?, phone=? WHERE id = $id";

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->bindParam(2, $display_name, PDO::PARAM_STR);
        $stmt->bindParam(3, $phone, PDO::PARAM_STR);
        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

// Delete one 
$app->delete('/friends/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $sql = "DELETE FROM friends WHERE id = $id";

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare($sql);

        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});
