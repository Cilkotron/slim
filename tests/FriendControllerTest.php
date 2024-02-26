<?php

use App\Controller\FriendController;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\ResponseFactory;
use DI\ContainerBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;

require_once __DIR__ . '/../src/FriendController.php';



class FriendControllerTest extends \PHPUnit\Framework\TestCase
{
    protected $controller;
    protected $container;

    protected function setUp(): void
    {
        $this->setUpController();
    }

    protected function setUpController() : void
    {
        $container = (new ContainerBuilder())
            ->addDefinitions(__DIR__ . '/../config/definitions.php')
            ->build();
        $this->setUpContainer($container);
        $this->controller = $container->get(FriendController::class);

    }
    protected function setUpContainer(ContainerInterface $container = null): void
    {
        if ($container instanceof ContainerInterface) {
            $this->container = $container;
            return;
        }
        throw new UnexpectedValueException('Container must be initialized');
    }

    public function testGetAllFriends()
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/friends');
        $response = (new ResponseFactory())->createResponse();
        $response = $this->controller->getAllFriends($request, $response, []);
        $this->assertSame(200, $response->getStatusCode());
    }

}
