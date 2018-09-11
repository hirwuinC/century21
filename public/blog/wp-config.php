<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'centuryc_wp924');

/** MySQL database username */
define('DB_USER', 'centuryc_wp924');

/** MySQL database password */
define('DB_PASSWORD', 'F902pp1@S!');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'yv5zbjkxvcczido4mk00matepa00qhap38akxq1zw0kksmv9vm2jusvk8x0xjvcy');
define('SECURE_AUTH_KEY',  'vl191wdduhk6tbrilbxe3ktpfaclrmysqr8nthec39w50wvovvvb4zpjzjeatq6r');
define('LOGGED_IN_KEY',    'ttlj2aoe2uzmvxxx2n3pguowljomwbhihnicrmy7wucivkyo6wovfhwy7bkrcj5n');
define('NONCE_KEY',        '3mqeelncao9t7e7du1wli5jodmcvfi7jrxajxuibxouwwgmxex7tucit45zuoa8c');
define('AUTH_SALT',        'alif1rfnesj1ygiazl43lsryvct723duoyree6kx8rfho9xzpu8ytjj0aewbojtv');
define('SECURE_AUTH_SALT', 'wkln7wtsdh38egkrbxpnjuicpwq3j9izrlxuafbjmj6tbxi0iy6c8miimbsk7vma');
define('LOGGED_IN_SALT',   'bh20gf6dlbrv9kpkk7fbh2fqmltl2liyig1pj8efiye7gcvtow3ax5owc8e72557');
define('NONCE_SALT',       'ckhfp9vrwql6rrfcbqdkzov3dwwcg2sfjbvimwdp6oeipwzo7o0bwax6hexsvgbv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp4v_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
