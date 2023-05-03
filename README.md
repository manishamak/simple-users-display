# Simple Users Display WordPress Plugin
It's a plugin used for displaying users and their details from 3rd-party remote server.
## Prerequisite
The Composer must be installed in your system. Composer (version >= 2) is recommended. 
## Installation
1. Clone this repository into plugins folder of your WordPress setup.
2. Go to the terminal and set this plugin's path in the terminal. Run 'composer install'.
3. Activate the plugin.
4. Go to 'your-site-url/sud-users-table' in the browser, and in cases where the redirect does not work as expected, please flush rewrite rules.

## Some Implementation Points
### Composer Packages
We have used 3 composer packages.
* inpsyde/php-coding-standards: For maintaining plugin's coding standard
    * For phpcs checks, you can use the command: 
      `./vendor/bin/phpcs --standard="Inpsyde" --ignore=*/vendor/* --extensions=php <path of the project>/wp-content/plugins/simple-users-display/` OR `composer run phpcs`
* phpunit/phpunit: For generating php unit test cases.
    * For unit test checks, you can use the command:
      `vendor/bin/phpunit` OR `composer run tests`
* brain/monkey: Used for generating test cases specifically for WordPress related functions.

### Cache 
- We have used WordPress Transients API which offers a simple and standardized way of storing cached data in the database temporarily by giving it a custom name and a timeframe after which it will expire and be deleted.
- We have stored the users data coming from API in the cache for limited time. Hence the data will display from cache till transient expires.

### Internationalization
- Plugin is consist of translation enabled strings. Hence the pot file has added in languages folder.

### Frontend assets
- Plugin is requesting bootstrap js and css files from its CDN server for achieving the drawer effect which displays the user details.
- It is having responsiveness.

### PHP Compatibility
- Compatible with php 8.1

## License
This plugin under GPL v3 [LICENSE](https://www.gnu.org/licenses/gpl-3.0.html)