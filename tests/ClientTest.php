<?php
namespace tests;

use Jira\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUser()
    {
        $config = include 'config-test.php';

        $client = new Client($config);

        $mockBody = Stream::factory(
            json_encode(
                [
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
                ]
            )
        );

        $mock = new Mock(
            [
                new Response(200, [], $mockBody),
            ]
        );

        // Add the mock subscriber to the client.
        $client->getHttpClient()->getEmitter()->attach($mock);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->getUser(['username' => "test_user"]);

        $this->assertEquals("test_user", $user['name']);
    }

    public function testAddUser()
    {
        $config = include 'config-test.php';

        $client = new Client($config);


        $mockBody = Stream::factory(
            json_encode(
                [
                    "self" => "http://www.example.com/jira/rest/api/2/user?username=test_user",
                    "name" => "test_user",
                    "key" => "test_user",
                    "emailAddress" => "test_user@domain.org",
                    "displayName"=> "Test User",
                ]
            )
        );

        $mock = new Mock(
            [
                new Response(201, [], $mockBody),
            ]
        );

        // Add the mock subscriber to the client.
        $client->getHttpClient()->getEmitter()->attach($mock);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->addUser(
            [
                "name" => "test_user",
                "emailAddress" => "test_user@domain.org",
                "displayName" => "Test User",
                "password" => "password123",
                "active" => "true" // This isn't implemented in their api yet, but we're hopeful!
            ]
        );

        $this->assertEquals("test_user", $user['key']);
    }


    public function testUpdateUser()
    {
        $config = include 'config-test.php';

        $client = new Client($config);

        $mockBody = Stream::factory(
            json_encode(
                [
                    "self" => "http://www.example.com/jira/rest/api/2/user?username=test_user",
                    "name" => "test_user",
                    "key" => "test_user",
                    "emailAddress" => "test_user@domain.org",
                    "displayName"=> "Test User",
                ]
            )
        );

        $mock = new Mock(
            [
                new Response(200, [], $mockBody),
            ]
        );

        // Add the mock subscriber to the client.
        $client->getHttpClient()->getEmitter()->attach($mock);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->updateUser(
            [
                "name" => "test_user",
                "emailAddress" => "test_112345455433@domain.org",
                "displayName" => "user display name",
                "active" => "true"
            ]
        );

        $this->assertEquals("test_user", $user['key']);
    }

    public function testDeleteUser()
    {
        $config = include 'config-test.php';

        $client = new Client($config);

        $mockBody = Stream::factory('{}');

        $mock = new Mock(
            [
                new Response(204, [], $mockBody),
            ]
        );

        // Add the mock subscriber to the client.
        $client->getHttpClient()->getEmitter()->attach($mock);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->deactivateUser(
            [
                "name" => "test_user",
            ]
        );

        $this->assertEquals(204, $user['statusCode']);

    }
}