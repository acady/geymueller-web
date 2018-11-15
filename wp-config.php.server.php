<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
 
// Include local configuration
if (file_exists(dirname(__FILE__) . '/local-config.php')) {
	include(dirname(__FILE__) . '/local-config.php');
}

// Global DB config
if (!defined('DB_NAME')) {
	define('DB_NAME', 'geymueller');
}
if (!defined('DB_USER')) {
	define('DB_USER', 'geymueller');
}
if (!defined('DB_PASSWORD')) {
	define('DB_PASSWORD', 'geymueller');
}
if (!defined('DB_HOST')) {
  // use database from server. requires SSH port forwarding like so:
  // ssh -f <your-user-name>@88.198.35.70 -L 7702:127.0.0.1:3306 -N
	define('DB_HOST', '127.0.0.1:7702');
}

/** Database Charset to use in creating database tables. */
if (!defined('DB_CHARSET')) {
	define('DB_CHARSET', 'utf8');
}

/** The Database Collate type. Don't change this if in doubt. */
if (!defined('DB_COLLATE')) {
	define('DB_COLLATE', '');
}
/** AUTO Update Wordpress **/
define( 'WP_AUTO_UPDATE_CORE', true );


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'kzV4M|$iXDbfCpqU[EwQ%L)`C@^Ltp+VB(Ql@0<}7swFdqp6eDbPn%F^.u@6{s[e');
define('SECURE_AUTH_KEY',  'ct7#@(f/%j4M+ZuXO~-K+D7v/KnH`@k@!Y?d|: V62hT$fBNH%tZFtok$w<-6aAE');
define('LOGGED_IN_KEY',    'it69%YzH8:5+b_.;B(7?]}%r#:_hUI#$w3!~}4V$EGQV.0mQ~A0A*cTFZVG+zlnL');
define('NONCE_KEY',        'A0]hT#S>d;`3G={X`y-Q@BwZgLncpMF7l67~9q_<`i6U|v9 r-0-lq an/fj0-n,');
define('AUTH_SALT',        'bYjkK2YJ:)1Z<E8:L0V3dLABwo3kH/yl:**0YOac=O;Pc,63`+0;6>px)Fh3KW#:');
define('SECURE_AUTH_SALT', '40e0!c9C;4Qf7`|^WsbN,m<{K[bmW?yB`!^FW%Byo]cBloY8hE>nwN|Jm6C=__&5');
define('LOGGED_IN_SALT',   'a++C>3tBs.hy&@#)`HW]Cb%nXAbh[vzC^0b<SCDoUUZwQCu+pS681_7`Jn`%J.uz');
define('NONCE_SALT',       'oaLz!|h]_%Lp@j&VM#P4F9,*Ucn2,TVFEo#y1e}c^wzAFz+$aPdp9`8;c*:98rWa');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');


/**
 * Set custom paths
 *
 * These are required because wordpress is installed in a subdirectory.
 */
if (!defined('WP_SITEURL')) {
	define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] . '/cms');
}
if (!defined('WP_HOME')) {
	define('WP_HOME',    'http://' . $_SERVER['SERVER_NAME'] . '');
}
if (!defined('WP_CONTENT_DIR')) {
	define('WP_CONTENT_DIR', dirname(__FILE__) . '/content');
}
if (!defined('WP_CONTENT_URL')) {
	define('WP_CONTENT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/content');
}


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
if (!defined('WP_DEBUG')) {
	define('WP_DEBUG', true);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
