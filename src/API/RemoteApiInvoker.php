<?php

declare(strict_types=1);

namespace SimpleUsers\API;

use SimpleUsers\Cache\TransientCache;
use SimpleUsers\SimpleUsersDisplay;

/**
 * API remote invoker.
 **/
class RemoteApiInvoker
{
    /**
     * Check data from the cache, if not present then requesting data to sud API.
     *
     * @param  string  $apiEndpoint  Endpoint URL
     *
     * @return array  $apiData       API data|Error
     */
    public function retrieveApiData(string $apiEndpoint): array
    {
        // Get data from the cache.
        $transientObj = new TransientCache($apiEndpoint);
        $cacheData = $transientObj->receiveTransientData();
        // Check the cache data exits or not.
        if (false !== $cacheData) {
            return $this->decodeApiData($cacheData);
        }
        // API endpoint.
        $apiUsersUrl = SimpleUsersDisplay::$api . $apiEndpoint;
        // Fetch data from the sud API.
        $response = $this->remoteResponse($apiUsersUrl);
        // Check API response is valid or not.
        if (is_wp_error($response)) {
            return $this->receiveErrorJson($response);
        }
        $apiData = $this->fetchResponseBody($response, $transientObj);
        return $apiData;
    }

    /**
     * Call remote API.
     *
     * @param  string  $apiUsersUrl  Full API URL
     *
     * @return array  $response      Response data
     */
    public function remoteResponse(string $apiUsersUrl): array
    {
        $response = (array) wp_remote_get($apiUsersUrl);
        return $response;
    }

    /**
     * Retrieve error details.
     *
     * @param  array   $errorObj        Error object
     * @param  string  $customErrorMsg  Error message
     *
     * @return array  Error message.
     */
    //phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration
    public function receiveErrorJson($errorObj = null, $customErrorMsg = null): array
    {
        $errorObjMessage = !empty($errorObj) ? get_error_message($errorObj) : '';
        $errorMsg = !empty($customErrorMsg) ? $customErrorMsg : $errorObjMessage;
        return [
            'is_error' => $errorMsg,
        ];
    }

    /**
     * Retrieve response body from API.
     *
     * @param  array           $response      Response body
     * @param  TransientCache  $transientObj  Instance of TransientCache
     *
     * @return array           $apiData       API data|Error
     */
    public function fetchResponseBody(array $response, TransientCache $transientObj): array
    {
        $apiData = wp_remote_retrieve_body($response);
        if (is_wp_error($apiData)) {
            return $this->receiveErrorJson($apiData);
        }
        if (empty($apiData) || count(json_decode($apiData, true)) <= 0) {
            return $this->receiveErrorJson('', __('No users found', 'simple-users-display'));
        }
        $transientObj->addTransientData($apiData);
        return $this->decodeApiData($apiData);
    }

     /**
     * Retrieve response code from API.
     *
     * @param  array   $response       Response body
     *
     * @return int     $responseCode   Response code
     */
    public function fetchResponseCode(array $response): int
    {
        $responseCode = wp_remote_retrieve_response_code($response);
        return $responseCode;
    }

    /**
     * Decode API response body.
     *
     * @param  string  $jsonData     JSON string
     *
     * @return array  Decoded data
     */
    public function decodeApiData(string $jsonData): array
    {
        return (array) json_decode($jsonData);
    }
}
