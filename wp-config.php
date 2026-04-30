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
define( 'DB_NAME', 'db_flexbase' );

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
define( 'AUTH_KEY',         't|8GmqsMSmU6^=HF[+DuFv [2>OB4!x(D2(@010B|k}NL,i_*.brvv8!,4<CK-fe' );
define( 'SECURE_AUTH_KEY',  '0r`yqe;/)Xi]NR%?:t&Op&ldQVp^Pb4yL7%j`y0~*rD)8dtM(UE`uxv_#O.UF087' );
define( 'LOGGED_IN_KEY',    'xp90OfwnB`znRl_-/,y @]<N9V [D1{2VCl?|F}Y0<78*uY]n9m-{q51>~ hSjXu' );
define( 'NONCE_KEY',        'Sq=)PLn&#N $~=0mxrV|@@%_OWreJbmFQE:}[@F&2vU[$wl@&e.+G6uNOK?4;f!D' );
define( 'AUTH_SALT',        'LPh~m?}kK<PXz56uH?J`;{Csw>8,[0p0T3&G5[Mfh`Zu-NKlpG1G!}L22:P$$}zt' );
define( 'SECURE_AUTH_SALT', '6FWkjQVPp0?F,i<m}k2.#PIezzxULoS?xj80/+!5BbM1UL<(VT<ca nrETZ3+z ^' );
define( 'LOGGED_IN_SALT',   'F<D*O<%KnNu#0W<&-GP.eK]/W~pIpnCoq=Hd}vt=hawIFBLY3#6%q&4<T]L/YkSh' );
define( 'NONCE_SALT',       'pix{mmVb8v2`0vg31J3wBLlLN<9k(aDC/iy]vg&cFc:WZo+(=AMh4P9HPf>mFY5w' );

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
