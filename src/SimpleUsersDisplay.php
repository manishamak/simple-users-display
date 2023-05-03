<?php

declare(strict_types=1);

namespace SimpleUsers;

use SimpleUsers\Common\ManageWPEndpoint;

/**
 *  Main class
 **/
class SimpleUsersDisplay
{
    /**
     * Custom page slug
     *
     * @var string
     */
    protected $customEndPoint = 'sud-users-table';

    /**
     * API endpoint
     *
     * @var string
     */
    // phpcs:disable Inpsyde.CodeQuality.ForbiddenPublicProperty
    public static $apiEndPoint = 'users';

    /**
     * API URL
     *
     * @var string
     */
    // phpcs:disable Inpsyde.CodeQuality.ForbiddenPublicProperty
    public static $api = 'https://jsonplaceholder.typicode.com/';

    /**
     * Define constants, hooks and initiate functions. Assigning values to variables
     */
    public function load()
    {
        $this->defineConstants();
        $this->initiate();
    }

    /**
     * init functions at the time of plugin loads
     */
    private function initiate()
    {
        // Call manage WordPress endpoint on plugin initialize.
        $manageWpEndpoint = new ManageWPEndpoint($this->customEndPoint);
        load_plugin_textdomain('simple-users-display', false, SUD_PLUGIN_PATH . '/languages');
    }

    /**
     * Define constant if not set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define(string $name, string $value)
    {
        if (! defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Define plugin constants.
     */
    private function defineConstants()
    {
        $this->define('SUD_PLUGIN_PATH', plugin_dir_path(SUD_PLUGIN_FILE));
        $this->define('SUD_PLUGIN_URL', plugin_dir_url(SUD_PLUGIN_FILE));
    }
}
