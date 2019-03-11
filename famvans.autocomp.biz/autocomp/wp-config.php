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
define('DB_NAME', 'autocomp_famvans');

/** MySQL database username */
//define('DB_USER', 'autocomp_famvans');
define('DB_USER', 'root');

/** MySQL database password */
//define('DB_PASSWORD', 'dealerclick1000');
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
define('AUTH_KEY',         'mc0j]DDDAhh34~s4}tBaR*s&)fV;d:`AN2c8J0+g%6.(h0EWavi~#)L@bamN/bm/');
define('SECURE_AUTH_KEY',  '3(1Z3<P8TUAb-e6bpH,&r~qOsPFGh&i JdEHs6QfNwyT|m$,!0`h(;8E`xh_6J$k');
define('LOGGED_IN_KEY',    'sL|ABht46}$ORQ=cg1?f4vG5VHMZ:EHG+1U(?q?16TAB=Tm9,Q1[?k/w5|!Y}XxD');
define('NONCE_KEY',        'NtwO:9r/:<#d*;4F6)Y)3Df57]7awvqgM*C@>%:)#9CkR8nDkH]J$ti?UpgJb;,h');
define('AUTH_SALT',        '}-3]Y }K.Vd(6oN@ )X?a9P=0n6[w}RK:d`}-_&r.,k{L=iF&Fwrt :,nX[8q=1E');
define('SECURE_AUTH_SALT', 'v>fz_sS@BC_t?4Bnu==ujp<+4 -!fNo1]&~k;}3nrk`w0GP Sv+ko|O^pfK,!aMP');
define('LOGGED_IN_SALT',   '0>lB%| rpe=(t.O]}(k&YKHMi>>%0IQ7NdK:y+r+.-d KsnJ_<Xj(iJe+q_9U`RR');
define('NONCE_SALT',       'kl#]0F#q/}K<Q:31#nxiLGY1_hs=}oHdA+s<PX(nPq[@@)@?yL-iRf}A#2!36fj)');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
