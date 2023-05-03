<?php

declare(strict_types=1);

namespace SimpleUsers\Tests\Unit\testcases;

use SimpleUsers\Tests\Unit\inc\SimpleUsersDisplayTestCase;
use Brain\Monkey\Functions;
use SimpleUsers\Common\ManageWPEndpoint;
use SimpleUsers\Common\RegisterRewriteRules;

/**
 * Check actions and filters exist or not.
 */
class HasActionsAndFiltersTest extends SimpleUsersDisplayTestCase
{
    /**
     * Check action exists.
     */
    public function testHasActions()
    {
        $expectedEndpoint = 'sud-users-table';
        $manageWpEndpoint = new ManageWPEndpoint($expectedEndpoint);
        // Check WP enqueue script action.
        // phpcs:ignore Inpsyde.CodeQuality.LineLength.TooLong
        $hasWpEnqueueAction = has_action('wp_enqueue_scripts', [ $manageWpEndpoint, 'sudFrontendScripts' ]);
        $hasWpEnqueueAction = false !== $hasWpEnqueueAction ? true : false;
        self::assertTrue($hasWpEnqueueAction);

        // Check template include action.
        // phpcs:ignore Inpsyde.CodeQuality.LineLength.TooLong
        $hasTemplateIncludeAction = has_action('template_include', [ $manageWpEndpoint, 'loadCustomTemplate' ]);
        $hasTemplateIncludeAction = false !== $hasTemplateIncludeAction ? true : false;
        self::assertTrue($hasTemplateIncludeAction);

        // Check register rewrite rule.
        $rewrite = new RegisterRewriteRules($expectedEndpoint);
        $hasInitRewriteAction = has_action('init', [ $rewrite, 'registerCustomEndpoint' ]);
        $hasInitRewriteAction = false !== $hasInitRewriteAction ? true : false;
        self::assertTrue($hasInitRewriteAction);
    }

    /**
     * Check filter exists.
     */
    public function testHasFilter()
    {
        $expectedEndpoint = 'sud-users-table';
        // Check query vars filter exists.
        $rewrite = new RegisterRewriteRules($expectedEndpoint);
        $hasInitQueryVarsFilter = has_filter('query_vars', [ $rewrite, 'addQueryVars' ]);
        $hasInitQueryVarsFilter = false !== $hasInitQueryVarsFilter ? true : false;
        self::assertTrue($hasInitQueryVarsFilter);
    }
}
