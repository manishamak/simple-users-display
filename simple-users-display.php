<?php

/**
 * Plugin Name:       Simple Users Display
 * Description:       Display users list and their characteristics
 * Version:           1.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            KrishaWeb PVT LTD
 * Author URI:        https://www.krishaweb.com/
 * License:           GPL v3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       simple-users-display
 * Domain Path:       /languages
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 **/

declare(strict_types=1);

// phpcs:disable PSR1.Files.SideEffects
// Check abspath exists or not.
if (! defined('ABSPATH')) {
    exit;
}

if (! defined('SUD_PLUGIN_FILE')) {
    define('SUD_PLUGIN_FILE', __FILE__);
}

if (! defined('SUD_PLUGIN_VERSION')) {
    define('SUD_PLUGIN_VERSION', 1.0);
}

// phpcs:disable Inpsyde.CodeQuality.LineLength
// Inclusion of main class
if (file_exists(__DIR__ . '/vendor/autoload.php') && !class_exists('SimpleUsers\SimpleUsersDisplay')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

if (class_exists('SimpleUsers\SimpleUsersDisplay')) {
    $usersData = new SimpleUsers\SimpleUsersDisplay();
    $usersData->load();
}
