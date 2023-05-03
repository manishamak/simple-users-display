<?php

declare(strict_types=1);

namespace SimpleUsers\Tests\Unit\testcases;

use SimpleUsers\Tests\Unit\inc\SimpleUsersDisplayTestCase;
use Brain\Monkey\Functions;
use SimpleUsers\Common\ManageWPEndpoint;

/**
 * Check template exists or not.
 */
class CheckTemplateExistsTest extends SimpleUsersDisplayTestCase
{
    /**
     * Check of template is valid.
     */
    public function testCheckTemplateExists()
    {
        $templatePath = SUD_PLUGIN_PATH . '/../../templates/users-list-template.php';
        $expectedEndpoint = 'sud-users-table';
        $wpEndpointStub = new ManageWPEndpoint($expectedEndpoint);
        Functions\when('__')->justReturn('%1$s template file not found');
        Functions\when('get_404_template')->justReturn('404');
        // phpcs:ignore Inpsyde.CodeQuality.LineLength.TooLong
        self::assertStringContainsString('users-list-template.php', $wpEndpointStub->checkFileExists($templatePath));
    }

    /**
     * Check of template not found.
     */
    public function testTemplateNotFound()
    {
        $templatePath = SUD_PLUGIN_PATH . '/../../templates/users-list-template-404.php';
        $expectedEndpoint = 'sud-users-table';
        $wpEndpointStub = new ManageWPEndpoint($expectedEndpoint);
        Functions\when('__')->justReturn('%1$s template file not found');
        Functions\when('get_404_template')->justReturn('404');
        self::assertStringContainsString('404', $wpEndpointStub->checkFileExists($templatePath));
    }
}
