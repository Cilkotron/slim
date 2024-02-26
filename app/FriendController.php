<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;



class FriendController
{

    public function __construct(protected ContainerInterface $container)
    {
        //$this->container = $container;
    }

    public function getAllFriends(Request $request, Response $response, array $args)
    {
        // Get all 
        $sql = "SELECT * FROM friends";
        try {
            if ($this->container->has('db')) {
                $db = $this->container->get('db');
            }
            $conn = $db->connect();
            $stmt = $conn->query($sql);
            $friends = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $db = null;
            $response->getBody()->write(json_encode($friends));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
    public function getFriend(Request $request, Response $response, array $args)
    {
        //Get single
        $id = $args['id'];
        $sql = "SELECT * FROM friends WHERE id = $id";
        try {
            if ($this->container->has('db')) {
                $db = $this->container->get('db');
            }
            $conn = $db->connect();
            $stmt = $conn->query($sql);
            $friend = $stmt->fetch(\PDO::FETCH_OBJ);
            $db = null;
            $response->getBody()->write(json_encode($friend));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
    public function createFriend(Request $request, Response $response, array $args)
    {
        // Create 
        $data = $request->getParsedBody();
        $email = $data['email'];
        $display_name = $data['display_name'];
        $phone = $data['phone'];
        $sql = "INSERT INTO friends (email, display_name, phone) VALUE (:email, :display_name, :phone)";
        try {
            if ($this->container->has('db')) {
                $db = $this->container->get('db');
            }
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
        } catch (\PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
    public function updateFriend(Request $request, Response $response, array $args)
    {
        // Update friend
        $id = $args['id'];
        $data = $request->getParsedBody();
        $email = $data['email'];
        $display_name = $data['display_name'];
        $phone = $data['phone'];
        $sql = "UPDATE friends SET email=?, display_name=?, phone=? WHERE id = $id";
        try {
            if ($this->container->has('db')) {
                $db = $this->container->get('db');
            }
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $email, \PDO::PARAM_STR);
            $stmt->bindParam(2, $display_name, \PDO::PARAM_STR);
            $stmt->bindParam(3, $phone, \PDO::PARAM_STR);
            $result = $stmt->execute();
            $db = null;
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
    public function deleteFriend(Request $request, Response $response, array $args)
    {
        // Delete one 
        $id = $args['id'];
        $sql = "DELETE FROM friends WHERE id = $id";
        try {
            if ($this->container->has('db')) {
                $db = $this->container->get('db');
            };
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute();
            $db = null;
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
   
   
   
}
