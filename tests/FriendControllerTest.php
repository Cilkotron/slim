<?php

use App\Controller\FriendController;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\ResponseFactory;;
use DI\ContainerBuilder;

require_once __DIR__ . '/../src/FriendController.php';



class FriendControllerTest extends \PHPUnit\Framework\TestCase
{

    protected $controller;

    protected function setUp(): void
    {
        $this->setUpController();
    }

    protected function setUpController(): void
    {
        $container = (new ContainerBuilder())
            ->addDefinitions(__DIR__ . '/../config/definitions.php')
            ->build();
        $this->controller = $container->get(FriendController::class);
        var_dump($this->controller);

    }
    public function testGetAllFriends()
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/friends');
        $response = (new ResponseFactory())->createResponse();

        $result = $this->controller->getAllFriends($request, $response, []);
        $this->assertSame(200, $result->getStatusCode());
    }
}
