<?php

use App\Controller\FriendController;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\ResponseFactory;;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use UnexpectedValueException;

require_once __DIR__ . '/../src/FriendController.php';



class FriendControllerTest extends \PHPUnit\Framework\TestCase
{
    protected $controller;
    protected $container;

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
        $this->setUpContainer($container);

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
        $result = $this->controller->getAllFriends($request, $response, []);
        $this->assertSame(200, $result->getStatusCode());
    }
}
