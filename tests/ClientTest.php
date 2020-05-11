<?php
namespace tests;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Jira\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUser()
    {
        $config = include 'config-test.php';

        $mockBody = json_encode([
                    "self" => "http://www.example.com/jira/rest/api/2/user?username=test_user",
                    "name" => "test_user",
                    "emailAddress" => "test_user@domain.org",
                    "avatarUrls" => [
                        "24x24" => "http://www.example.com/jira/secure/useravatar?size=small&ownerId=test_user",
                        "16x16" => "http://www.example.com/jira/secure/useravatar?size=xsmall&ownerId=test_user",
                        "32x32" => "http://www.example.com/jira/secure/useravatar?size=medium&ownerId=test_user",
                        "48x48" => "http://www.example.com/jira/secure/useravatar?size=large&ownerId=test_user"
                    ],
                    "displayName"=> "Test User",
                    "active"=> true,
                    "timeZone"=> "Australia/Sydney",
                    "groups"=> [],
        ]);

        $client = $this->getMockClient($mockBody, 200);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->getUser(['username' => 'test_user']);

        $this->assertEquals("test_user", $user['name']);
    }

    public function testAddUser()
    {
        $mockBody = json_encode([
            "self" => "http://www.example.com/jira/rest/api/2/user?username=test_user",
            "name" => "test_user",
            "key" => "test_user",
            "emailAddress" => "test_user@domain.org",
            "displayName"=> "Test User",
        ]);

        $client = $this->getMockClient($mockBody, 201);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->addUser([
            "name" => "test_user",
            "emailAddress" => "test_user@domain.org",
            "displayName" => "Test User",
            "password" => "password123",
            "active" => true // This isn't implemented in their api yet, but we're hopeful!
        ]);

        $this->assertEquals("test_user", $user['key']);
    }

    public function testUpdateUser()
    {
        $mockBody = json_encode([
            "self" => "http://www.example.com/jira/rest/api/2/user?username=test_user",
            "name" => "test_user",
            "key" => "test_user",
            "emailAddress" => "test_user@domain.org",
            "displayName"=> "Test User",
        ]);

        $client = $this->getMockClient($mockBody, 200);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->updateUser([
            "username" => "test_user",
            "emailAddress" => "test_112345455433@domain.org",
            "displayName" => "user display name",
            "active" => true
        ]);

        $this->assertEquals("test_user", $user['key']);
    }

    public function testDeleteUser()
    {
        $mockBody = '{}';

        $client = $this->getMockClient($mockBody, 204);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->deleteUser([
            "username" => "test_user",
        ]);

        $this->assertEquals(204, $user['statusCode']);
    }

    public function testSearchForUserByEmail()
    {
        $mockBody = json_encode([
            "self" => "http://www.example.com/jira/rest/api/2/user?username=test_user",
            "avatarUrls"=> [
                "24x24" => "http://www.example.com/jira/secure/useravatar?size=small&ownerId=fred",
                "16x16" => "http://www.example.com/jira/secure/useravatar?size=xsmall&ownerId=fred",
                "32x32" => "http://www.example.com/jira/secure/useravatar?size=medium&ownerId=fred",
                "48x48" => "http://www.example.com/jira/secure/useravatar?size=large&ownerId=fred"
            ],
            "name" => "test_user",
            "key" => "test_user",
            "emailAddress" => "test_user@domain.org",
            "displayName"=> "Test User",
            "active" => true
        ]);

        $client = $this->getMockClient($mockBody, 200);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->searchForUser([
            "username" => "test_user",
        ]);

        $this->assertEquals("test_user", $user['key']);
    }

    /**
     * @param $mockBody
     * @return Client
     */
    private function getMockClient($mockBody, $responseCode)
    {
        $config = include 'config-test.php';

        $mockHandler = new MockHandler([
            new Response($responseCode, [], $mockBody),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(array_merge([
            'http_client_options' => [
                'handler' => $handlerStack,
            ]
        ], $config));
        return $client;
    }
}
