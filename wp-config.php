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
define('DB_NAME', 'danmanhinh');

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
define('WP_LOAD_IMPORTERS', true);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '4*c+rvsq|Z)oX <`Lq<t|8([N8yoL]#x; .EL%6}22DQ}gl|{:8V|r?o+&ZWnn5N');
define('SECURE_AUTH_KEY',  'y>:xf>=JAqP-n^zlS/^(3 EUZUB64/1_Txi*Dq?yrh$P%~`iA9z{hVDT_}3&/Lng');
define('LOGGED_IN_KEY',    'gx!y<9.s)syep:!sqni&w!!]:p3pTXMU)GHLYLrvR5(UQx&%rq2+=YaM9=%hzL^B');
define('NONCE_KEY',        'xyH:A2?hlO}!%pX?t*`|D.xbw=F[iE@/St(SJ03O|Cb!c_puk1dt(BpUH.XShjZ}');
define('AUTH_SALT',        '#+xgh)l V b76=JKYvq#+*f,^klxeUptkjIq@jDIg5:/0mqRpU^[PklR$|M|@3X3');
define('SECURE_AUTH_SALT', '23SEJrY.YTd[rfoul5d~:HiO2|[9=/#R#_@?KzSbU~c`LD9T;GR=u>RDI*sDrlv#');
define('LOGGED_IN_SALT',   'S?mYp:Fo%2O#.rVo(0+6R?EA>#>VRyVjU5CfA>?vZqy-Td{|xEHM-!Lq|5bV6c}C');
define('NONCE_SALT',       '1gNQ0d)B3*l[K9s*>C]2r!D4+wT5<zif@,/d<}DT-?A6#M^Anx.Z$D.2BZEe3_Ta');

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
