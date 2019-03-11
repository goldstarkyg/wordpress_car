<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define('DB_NAME', 'autocompus_passport');

/** MySQL database username */
//define('DB_USER', 'autocompus_passport');
define('DB_USER', 'root');

/** MySQL database password */
//define('DB_PASSWORD', 'DealerClick1000');
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
define('AUTH_KEY',         '64JWjlX*f!@1%d%2B sZ.~{j$9P`oVtbX{BSp^u~4d!N<4}Q?|%rrU:tnWl r}]7');
define('SECURE_AUTH_KEY',  'Z<dAB^uC$A),ir,xU6_D-39?:}7_aSe5QtPt{&EaDx-f7~U8]`iVpV4>lm`6(&<$');
define('LOGGED_IN_KEY',    '0~@jBHcc|gj]ha)IrGu~o,1<2h)$i6F0X!}TlL/yW$o7PfZLvpMRn*Zh,H=E:9_A');
define('NONCE_KEY',        'pw<6#%6-d%iE,Ow3z9j+Wu(I9rI3F;:pr>q>IDWu@_qPvg|ZV/i2O.8nQAlWr^%{');
define('AUTH_SALT',        '%774;u>8(_AEYHHS:zg+VB3Wd+BB[2&b^:1a0gH?zBxOl_UOQb[UA{4Z@?;H:A%k');
define('SECURE_AUTH_SALT', '>V}ziJpv8#}H%%1cS<ZFfadE)RZKm}mciB;fT-RkQ^qFbzSIFhaRL(U9mG4L 7` ');
define('LOGGED_IN_SALT',   'ritJ_}HTu+K(wSS$s4(k}N<{ZH63&B>;;-tXKn)ehJWbZ? MDcC1afe/Oqo+>@HV');
define('NONCE_SALT',       'c6i)`kT2B4t2)&m0snxPD3`~el(F5lt/Lr3tYLK*}D`t;.8!KZ.muOdlW5kD80<*');

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
