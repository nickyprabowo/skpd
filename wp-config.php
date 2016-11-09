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
define('DB_NAME', 'bpmpkb');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'b[;]$V}d^zVg/=[vwyr>@^:|<,ubXu9v1aD8YuNDhCs @JpW~U@Y!d#d/XZOCwF^');
define('SECURE_AUTH_KEY',  '1S]z#xpQ8<>Qy`*[HWA;(j{ro*}^!^63|&B7Jhda9QN6NHnTf41%{nioB,Q-5fd2');
define('LOGGED_IN_KEY',    'OiaQs{7/uz[DqOZ2Qx>iAf)d!lDk)v$,?k%zQXLF&Wmc36[B]YS~:Kv1kC<PQmJy');
define('NONCE_KEY',        '?cJ~ PPnQ)Nr(+NHyc7a=TA.QcrE`Ais+}Ro3w$J!=Z.CzQqyOjPhcyJ=D<h,M^m');
define('AUTH_SALT',        'aq{)-W@1t9[W0mQ~ll8u+8#*C|l1r^|. $g]>p-96}K^pE;4ehGpWEr06/jTKE^]');
define('SECURE_AUTH_SALT', 'u2w^-@QblrV%Y+[NI;+$bd&3&`!M}-Pw=iWKOA@R>C{?7?Alof[%>@u#|G4htg<e');
define('LOGGED_IN_SALT',   '~F.#6ISYVaVyUgOsh4^]@@.Y_n#e`V!qcTTr<:G#?p[htZb^^&G&%k?BUqH~./JP');
define('NONCE_SALT',       'B):nHJ=1W=h=e(86mZeZdrYZ4}-$.kQX!B4ol}?~=,Z 9EmD{swrv55ljclNA^Dn');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'amz_';

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
