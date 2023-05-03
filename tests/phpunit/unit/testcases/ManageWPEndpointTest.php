<?php

declare(strict_types=1);

namespace SimpleUsers\Tests\Unit\testcases;

use SimpleUsers\Tests\Unit\inc\SimpleUsersDisplayTestCase;
use Brain\Monkey\Functions;
use SimpleUsers\Common\ManageWPEndpoint;

/**
 * Manage WP endpoint testcase.
 */
class ManageWPEndpointTest extends SimpleUsersDisplayTestCase
{
    /**
     *  Test user list page.
     */
    public function testIsUserListingPage()
    {
        global $wp;
        $wp = \Mockery::mock(WP::class);
        $wp->request = 'sud-users-table';
        $expectedEndpoint = 'sud-users-table';
        Functions\when('get_query_var')->justReturn('sud_user_list');
        $wpEndpointStub = new ManageWPEndpoint($expectedEndpoint);
        self::assertTrue($wpEndpointStub->isUserListingPage());
    }

    /**
     *  Test for the list page not found.
     */
    public function testIsNotUserListingPage()
    {
        global $wp;
        $wp = \Mockery::mock(WP::class);
        $wp->request = 'abc';
        $expectedEndpoint = 'sud-users-table';
        Functions\when('get_query_var')->justReturn('sud_user_list_404');
        $wpEndpointStub = new ManageWPEndpoint($expectedEndpoint);
        self::assertFalse($wpEndpointStub->isUserListingPage());
    }

    /**
     * Test user details page.
     */
    public function testViewUserDetailPage()
    {
        global $wp;
        $expectedEndpoint = 'sud-users-table';
        $wp = \Mockery::mock(WP::class);
        $wp->request = 'sud-users-table/view/1/';
        Functions\when('get_query_var')->justReturn(1);
        $wpEndpointStub = new ManageWPEndpoint($expectedEndpoint);
        self::assertTrue($wpEndpointStub->isUserViewPage());
    }
}
