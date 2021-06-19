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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
	define( 'WP_HOME', 'http://localhost/wordpress' );
	define( 'WP_SITEURL', 'http://localhost/wordpress' );	
} else if (strstr($_SERVER['SERVER_NAME'], '192.168.0.20')) {
	define( 'WP_HOME', 'http://192.168.0.20/wordpress' );
	define( 'WP_SITEURL', 'http://192.168.0.20/wordpress' );
} else{
	define( 'WP_HOME', 'http://201.190.229.112/wordpress' );
	define( 'WP_SITEURL', 'http://201.190.229.112/wordpress' );
}


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress_user' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wordpress_pss123' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '<X+[tuG:+?|M.CgR|#af1d6>KjQWl_*LrRR7M@2cE&R:6W4J VY6y32MUjki ?{D' );
define( 'SECURE_AUTH_KEY',  '-K44)V]<%+pF3Ux5AAZ%[)3$xalmWrA$I2^;h1|fv+986WC1_N5v[84yV*WVw3OY' );
define( 'LOGGED_IN_KEY',    '17p-^QdC$K@;ER]nB[fyWtS^-S&fX`lZ8n*P]nCpNM >g00F)-ETErCr:STw*0B(' );
define( 'NONCE_KEY',        'n 8-dN<m3v3]WKo1~:MxHC)En(`^6%f=`E405RB%F(<6IHtR4,~3R=$Y^.V-EAEO' );
define( 'AUTH_SALT',        'Y`YY9X;ego=}8YneZGcTL*_/&BfI7j6^d}6p-y%cD?:rQ?j3z_C2&4j}s1;cBQSF' );
define( 'SECURE_AUTH_SALT', 'VL!I&dcmq1&a}YgAr4>k0r3g^^Zc;Gms}8k%e@Fly=E)9j7RB-mHbK2@aa00uqE<' );
define( 'LOGGED_IN_SALT',   '2ioQCjF6f/K>6GvAY*$?>>1|aSv2}3grS3R#U6E+cQFD$g?uZtXmPg?<1J,DDmjY' );
define( 'NONCE_SALT',       'V$:g~m]}gUDWPgt -FhCV$v/J<GzGjt?gLb 9~^AW+xpL8ZIgZqd{zWta[[|`,5N' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
// define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
