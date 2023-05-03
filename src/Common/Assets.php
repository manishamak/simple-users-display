<?php

declare(strict_types=1);

namespace SimpleUsers\Common;

/**
 * Plugin assets.
 */
class Assets
{
    /**
     * Bootstrap cdn URL.
     *
     * @var string $bootstrap_cdn
     */
    private $bootstrapCdn = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/';

    /**
     * Register styles and scripts.
     */
    private function registerAssets()
    {
        // Register CSS.
        wp_register_style(
            'bootstrap',
            $this->bootstrapCdn . 'css/bootstrap.min.css',
            '',
            SUD_PLUGIN_VERSION
        );
        wp_register_style(
            'sud-style',
            SUD_PLUGIN_URL . 'assets/css/sud-style.css',
            ['bootstrap'],
            SUD_PLUGIN_VERSION
        );

        // Register JS.
        wp_register_script(
            'bootstrap',
            $this->bootstrapCdn . 'js/bootstrap.min.js',
            ['jquery'],
            SUD_PLUGIN_VERSION,
            true
        );
        wp_register_script(
            'sud-setting',
            SUD_PLUGIN_URL . 'assets/js/sud-setting.js',
            ['jquery', 'bootstrap'],
            SUD_PLUGIN_VERSION,
            true
        );
    }

    /**
     * Enqueue assets.
     */
    public function enqueueAssets()
    {
        $this->registerAssets();
        // Enqueue CSS/JS.
        wp_enqueue_style('sud-style');
        wp_enqueue_script('sud-setting');
    }

    /**
     * Localize script data.
     *
     * @param array   $data        Script data.
     * @param string  $handle      Register script handle.
     * @param string  $objectName  Localize script object.
     */
    public function localizeScriptData(array $data = [], string $handle = 'sud-setting', string $objectName = 'sud_js_obj') // phpcs:ignore Inpsyde.CodeQuality.LineLength.TooLong
    {
        wp_localize_script($handle, $objectName, $data);
    }
}
