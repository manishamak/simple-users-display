<?php

declare(strict_types=1);

namespace SimpleUsers\Common;

use SimpleUsers\API\RemoteApiInvoker;
use SimpleUsers\SimpleUsersDisplay;
use SimpleUsers\Log\ErrorLog;

/**
 * Manage user render functionality.
 **/
class ManageUserFunctions
{
    /**
     * Create instance of RemoteApiInvoker.
     *
     * @return RemoteApiInvoker
     */
    private function getRemoteInvokerInstance(): RemoteApiInvoker
    {
        return new RemoteApiInvoker();
    }

    /**
     * Fetch all users list.
     *
     * @return array $data
     */
    public function fetchUsersList(): array
    {
        $data = $this->getRemoteInvokerInstance()->retrieveApiData(SimpleUsersDisplay::$apiEndPoint);
        return $data;
    }

    /**
     * Render user details for the specific user.
     *
     * @return array $array User details.
     */
    public function sudShowUserDetails(): array
    {
        // Get user ID from query vars.
        $userId = !empty(get_query_var('user_id')) ? get_query_var('user_id') : 0;
        // Create api endpoint to get user details.
        $userEndpoint = trailingslashit(SimpleUsersDisplay::$apiEndPoint) . $userId;
        // Get user details by ID.
        $data = $this->getRemoteInvokerInstance()->retrieveApiData($userEndpoint);
        // Check api error exists or not.
        if (isset($data['is_error']) && ! empty($data['is_error'])) {
            // translators: translate %1$s to API endpoint.
            ErrorLog::log(sprintf(__('An error occurred while fetching user details, please check API endpoint: %1$s', 'simple-users-display'), SimpleUsersDisplay::$api . $userEndpoint), 'info', __FILE__, __LINE__); // phpcs:ignore Inpsyde.CodeQuality.LineLength.TooLong
            return $data;
        }
        return $data;
    }
}
