<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

// define('DB_NAME', 'Ecommerce'); // Your database name
// define('DB_USER', 'root'); // Your MySQL username
// define('DB_PASSWORD', ''); // Your MySQL password (leave empty if not set)
// define('DB_HOST', '127.0.0.1'); // DBngin’s MySQL host (use localhost or 127.0.0.1)
// define('DB_CHARSET', 'utf8mb4');
// define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'P?v9D~%$!YREW;_;&RlXgrtA}Upj}C*Hzc^d UNsfk01Z7Z.Da1NO79!%@foFT/x' );
define( 'SECURE_AUTH_KEY',  'hE3Ry;7 $e@a[{-0#H  -89n!Qs[0(R^CszEVpaj y/e9jScmL#a3A+et*4}/Ja ' );
define( 'LOGGED_IN_KEY',    'eJAE,HnSza#`+N+.j&Zf81@T[qB-@_FbhK[hhl}Ma?m}nX&.m&2~)[YnURUOB7YR' );
define( 'NONCE_KEY',        '}~3J`?n)?,!<7l*aG/ltAW5Uoz^ JrIl~Ct<-OjiYq.$~LDEa~ M-nKQ6_*--N74' );
define( 'AUTH_SALT',        '&2z!GQ.+pF>gZ=HdP^KXmj5(hl/ZbAA_E?3Qt~:I{}-8.(dDF^vV6]8J;tZb{_T ' );
define( 'SECURE_AUTH_SALT', '5]uc!Q+~jUDbp#c]BwJDTbH|t/)`FqM%G6JI%tulrX<5MG*8a^K]~R*8_I #~oJ7' );
define( 'LOGGED_IN_SALT',   '/^<y_]Ad`khgl&&kAs~3&8~#-{B=t8hG[;`-32u0x#QVGLg*:}h#!s1M9TGS/s7Z' );
define( 'NONCE_SALT',       'UPSB;$t3q4xAPQt$xsf^1!c-XpQ#6+ca,Hl++4h9zT*sT?bscXjwXL/YEq@)4Bgn' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
