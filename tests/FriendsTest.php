<?php 
use Sanja\SlimApi\App;
use Slim\Psr7\Environment;
use Slim\Psr7\Request;


class FriendsTest extends \PHPUnit\Framework\TestCase {
    protected $app;

    public function testGetApp() 
    {
        $this->app = (new App())->get();
    }
   public function testFriendsGet() {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/friends/all',
            ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame((string)$response->getBody(), "Hello, Todo");
    } 
    

}