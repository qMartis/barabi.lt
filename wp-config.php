<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'barabi_new' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '4n9`g_yBhq7ef^G#j,V0mn)pmCi#.5iGWTbZv_T3wC /sq]/b=N6b%6cJ`R00X/{' );
define( 'SECURE_AUTH_KEY',   'dVm>NPfnl`TqmgpTo2q!K5@gLYRDWm+gHn9A^rp#ZNmfG%S?OO7[N2dU.}iRu?bM' );
define( 'LOGGED_IN_KEY',     '_X+Y<7[Q}`SQM.QivYdxu_MGnuVGed%=$8I)-@f$fdIW:tT@I]cP@#NU)R2x/*%9' );
define( 'NONCE_KEY',         'n*C:&2.[!5!w_hd2regEcD]~Z.}XO{+5d]|9&!TsLAw:Y2+.Vc(O5I)zk(ocQ[]p' );
define( 'AUTH_SALT',         '6-6`(VWWV5iAL4,(/^RN+*QX|rf9!fjv4bb.CtSwo_?tOo;%alC]`T_qKat14)BP' );
define( 'SECURE_AUTH_SALT',  '->Qy@~-D:1$u^[1`MNf1R3e4*_6mc.b@<d8FR!Z,i)XUTieoLwBXI`@,Ek;Y}<l;' );
define( 'LOGGED_IN_SALT',    'WPZ4L4(w-fkP%HQUby_^e{)lY k%U-2TU/L![;;w%w}[VCQo 9h[i%{i>4/-s]K`' );
define( 'NONCE_SALT',        'CCT%>0C|R_E}3TEAHmCD;+U@Y<RMyc3dz|@7}`u`a2p7>.]LlgE*Yf&|K#l:->0|' );
define( 'WP_CACHE_KEY_SALT', 'BUTs>z)T@KxI;j5V(Vd2+gB|gp0?`X3ofoC8c`IY>4[X^jk5i00`<E/.g4v#n!.q' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
