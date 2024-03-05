<?php

require_once __DIR__ . '/../app/FriendController.php';



class FriendControllerTest extends \PHPUnit\Framework\TestCase
{
    private $http;

    public function setUp(): void
    {
        // Create Guzzle Client 
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost:8888']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }


    /**
     * @test
     */
    public function getAllFriends() : void 
    {
        // Test response status 
        $response = $this->http->request('GET', 'friends');
        $this->assertEquals(200, $response->getStatusCode());

        //Test response content-type
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    /**
     * @test 
     */
    public function getFriend() : void 
    {
        //Test response status 
        $response = $this->http->request('GET', 'friends/2');
        $this->assertEquals(200, $response->getStatusCode());

        // Test response content-type 
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    /**
     * @test
     */
    public function createFriend() : void
    {
        //Test response status 
        $body = [
            'email' => 'sanjabudic@gmail.com',
            'display_name' => 'Sanja Budic',
            'phone' => ''
        ];

        $response = $this->http->request(
            'POST',
            'friends',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json'
                ],
                'json' => $body
            ]
        );
        $this->assertEquals(201, $response->getStatusCode());

        // Test response content-type 
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    /**
     * @test
     */
    public function updateFriend() : void
    {
        //Test response status 
        $toUpdate = [
            'email' => 'sanjabudic@gmail.com',
            'display_name' => 'Example',
            'phone' => '0123456789'
        ];
        $response = $this->http->request(
            'PUT',
            'friends/2',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json'
                ],
                'json' => $toUpdate
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());

        // Test response content-type 
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    /**
     * @test
     * @group delete 
     */
    public function deteleFriend() : void 
    {
        //Test response status 
        $response = $this->http->request('DELETE', 'friends/5');
        $this->assertEquals(200, $response->getStatusCode());

        // Test response content-type 
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }
}
