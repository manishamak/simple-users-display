<?php

declare(strict_types=1);

namespace SimpleUsers\Cache;

/**
 * Manange cache data.
 **/
class TransientCache
{
    /**
     * Transient key
     *
     * @var string
     */
    private $transientKey;

    /**
     * TransientCache constructor
     *
     * @param string $apiEndpoint
     */
    public function __construct(string $apiEndpoint)
    {
        $this->modifyTransientKey($apiEndpoint);
    }

    /**
     * Create transient key
     *
     * @param  string  $apiEndpoint   Endpoint of API URL
     */
    public function modifyTransientKey(string $apiEndpoint)
    {
        $transientKey = strpos($apiEndpoint, '/')
        ? str_replace('/', '_', $apiEndpoint)
        : $apiEndpoint;
        $this->transientKey = 'sud_' . $transientKey;
    }

    /**
     * Set data in transient cache for the 6 hours.
     *
     * @param  string  $transientData  Data to be stored in cache
     */
    public function addTransientData(string $transientData)
    {
        set_transient($this->transientKey, $transientData, 6 * HOUR_IN_SECONDS);
    }

    /**
     * Get transient cache data.
     *
     * @return  string  $transientData  Store cache data
     */
    //phpcs:disable Inpsyde.CodeQuality.ReturnTypeDeclaration
    public function receiveTransientData()
    {
        $transientData = get_transient($this->transientKey);
        return $transientData;
    }

    /**
     * Clear transient cache data.
     */
    public function removeTransientData()
    {
        delete_transient($this->transientKey);
    }
}
