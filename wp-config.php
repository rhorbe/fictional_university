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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'MBvu7yEYDUnlGzLH5W6wotwBiatBv8FWf5crUhLxpxpvYH9xmMpEqMhOlZak+8VrHysOM3TCwg3cO68H2t9IuA==');
define('SECURE_AUTH_KEY',  '1QrjV2LNkkGFnersDxbs+yD8pt/NJQnyDa+mA6ecEq9to4q6wsN/25DircmGSjhs8EEsCBf2I28Vq484WBeihQ==');
define('LOGGED_IN_KEY',    'BHolF1QFgAG2UxuO6p5fOkg/NyOlWlgDCmhBXDpiwMVwUYR1aVTfcScnAo0Bi3fABUcIbHN1sTLBHll3nySYeA==');
define('NONCE_KEY',        'U+t/bFik2YDFJIzuzV+nisPLL5iKktgsO+EOYIeQIDl7MApMaksfmIWjFf9sjnIBNtr9HuyTBpcwqTAotBUBlQ==');
define('AUTH_SALT',        'Wqm4ahKSqjSD6QSUa8isAdKFYs0eK4KzX6AurUmh7lp4Eq2fXPb/VXmwYKyy1oyXoVhvcoljFBqycc0oxdguWA==');
define('SECURE_AUTH_SALT', '8V5C5Gx3y3DBEPDGqAQdqrDRmf/xhv/d1Fq3AvcX6KhVwibDoAXa6KeqNAr6GslC642ggUQqZkfSVBtzkI7hHg==');
define('LOGGED_IN_SALT',   '1WZFC5dWm8+yv+mDKs3giY04mr8pAAil/zJYwaeNchOP5sd9cxquiG7KgeRX3LUJjmYF/pDEWWmzbkMKksO8ZQ==');
define('NONCE_SALT',       'tKDfsazEnw9XEKe3gqPed7EdB9CElp71fFqtXTOzO7UykBF9L+VpcH4Fb5Dhx1D3BxXwrKpd60hnxdce/pq0pw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
