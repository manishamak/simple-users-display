<?php

declare(strict_types=1);

namespace SimpleUsers\Tests\Unit\testcases;

use SimpleUsers\Tests\Unit\inc\SimpleUsersDisplayTestCase;
use Brain\Monkey\Functions;
use SimpleUsers\API\RemoteApiInvoker;

/**
 *  Remote API testcase.
 */
class RemoteApiInvokerTest extends SimpleUsersDisplayTestCase
{
    /**
     * Get record from the cache.
     */
    public function testRetrieveApiDataFromCache()
    {
        $expectedEndpoint = 'users';
        $userList = json_encode(\Mockery::type('array'));
        Functions\when('get_transient')->justReturn($userList);
        $remoteApiStub = new RemoteApiInvoker();
        self::assertJsonStringEqualsJsonString(
            $userList,
            json_encode($remoteApiStub->retrieveApiData($expectedEndpoint), JSON_FORCE_OBJECT),
        );
    }

    /**
     * Get API data.
     */
    public function testRetrieveApiData()
    {
        $expectedEndpoint = 'users';
        $expectedApiResponseInArray = ['foo' => 'bar'];
        $expectedApiResponse = json_encode($expectedApiResponseInArray);
        Functions\when('get_transient')->justReturn(false);
        Functions\expect('wp_remote_get')
            ->andReturn($expectedApiResponseInArray);
        Functions\when('is_wp_error')->justReturn(false);
        Functions\expect('wp_remote_retrieve_body')
            ->andReturn($expectedApiResponse);
        Functions\when('set_transient')->justReturn(true);
        define('HOUR_IN_SECONDS', '3600');
        Functions\when('__')->justReturn('No users found');
        $remoteApiStub = new RemoteApiInvoker();
        self::assertJsonStringEqualsJsonString(
            $expectedApiResponse,
            json_encode($remoteApiStub->retrieveApiData($expectedEndpoint), JSON_FORCE_OBJECT),
        );
    }

    /**
     * Get API data error.
     */
    public function testRetrieveApiDataError()
    {
        $expectedEndpoint = 'users';
        $expectedApiResponse = json_encode(\Mockery::type('array'));
        $expectedApiResponseInArray = ['foo' => 'bar'];
        Functions\when('get_transient')->justReturn(false);
        Functions\expect('wp_remote_get')
            ->andReturn($expectedApiResponseInArray);
        Functions\when('is_wp_error')->justReturn(true);
        Functions\expect('get_error_message')
            ->andReturn('error occur');
        $remoteApiStub = new RemoteApiInvoker();
        self::assertArrayHasKey('is_error', $remoteApiStub->retrieveApiData($expectedEndpoint));
    }

    /**
     * Check API response code.
     */
    public function testCheckApiResponseCode()
    {
        $apiUrl = \SimpleUsers\SimpleUsersDisplay::$api . 'users';
        $remoteApiInvoker = new RemoteApiInvoker();
        Functions\expect('wp_remote_get')->andReturn(['foo' => 'bar']);
        $response = $remoteApiInvoker->remoteResponse($apiUrl);
        Functions\when('wp_remote_retrieve_response_code')->justReturn(200);
        $responseCode = $remoteApiInvoker->fetchResponseCode($response);
        $isValidResponse = 200 === $responseCode ? true : false;
        self::assertTrue($isValidResponse);
    }
}
