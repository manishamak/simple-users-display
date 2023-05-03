<?php

declare(strict_types=1);

namespace SimpleUsers\Common;

use SimpleUsers\Common\RegisterRewriteRules as Rewrite;
use SimpleUsers\Common\Assets;
use SimpleUsers\Log\ErrorLog;

/**
 * Assign custom endpoint functions.
 **/
class ManageWPEndpoint extends ManageUserFunctions
{
    /**
     * Custom page slug.
     *
     * @var string
     */
    private $customEndPoint;

    /**
     * ManageWPEndpoint constructor.
     *
     * @param string  $wpEndpoint
     */
    public function __construct(string $wpEndpoint)
    {
        $this->customEndPoint = $wpEndpoint;
        $this->registerRewriteRule();
        $this->initHooks();
    }

    /**
     * Init hooks.
     */
    private function initHooks()
    {
        add_action('template_include', [$this, 'loadCustomTemplate']);
        add_action('wp_enqueue_scripts', [$this, 'sudFrontendScripts' ]);
    }

    /**
     * Register rewrite rules.
     */
    private function registerRewriteRule()
    {
        $rewrite = new Rewrite($this->customEndPoint);
    }

    /**
     * Render user list on template.
     *
     * @param string $template Template path
     */
    public function loadCustomTemplate(string $template)
    {
        if ($this->isUserListingPage()) {
            $template = $this->checkFileExists(SUD_PLUGIN_PATH . '/templates/users-list-template.php');
        }
        $this->loadWpTemplate($template);
    }

    /**
     * Check template file exists OR not.
     *
     * @param string $template File path.
     *
     * @return string
     */
    public function checkFileExists(string $template): string
    {
        try {
            if (!file_exists($template)) {
                $errorLogMsg = sprintf(
                    // translators: translate %1$s to template path.
                    __('%1$s template file not found', 'simple-users-display'),
                    $template
                );
                throw new \Exception($errorLogMsg);
            }
        } catch (\Exception $exe) {
            $template = get_404_template();
            ErrorLog::log($exe->getMessage(), 'info', __FILE__, __LINE__);
        }
        return $template;
    }

    /**
     * Load custom template to only allow custom endpoint.
     *
     * @param string  $template  Template Path.
     */
    public function loadWpTemplate(string $template)
    {
        // Load custom template.
        $userRows = $this->fetchUsersList();
        include($template);
        exit;
    }

    /**
     * Check if requested slug is desired custom-endpoint slug.
     *
     * @return bool
     */
    public function isUserListingPage(): bool
    {
        if (get_query_var('action') && 'sud_user_list' === get_query_var('action')) {
            return true;
        }
        return false;
    }

    /**
     * Check view page request for the user.
     *
     * @return bool
     */
    public function isUserViewPage(): bool
    {
        if (get_query_var('user_id') && is_numeric(get_query_var('user_id'))) {
            return true;
        }
        return false;
    }

    /**
     * Include styles and scripts.
     */
    public function sudFrontendScripts()
    {
        if ($this->isUserListingPage()) {
            $scriptData = [
                'page_url' => home_url($this->customEndPoint),
            ];
            $assets = new Assets();
            $assets->enqueueAssets();
            $assets->localizeScriptData($scriptData);
        }
    }
}
