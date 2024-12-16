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
define( 'DB_NAME', 'local' );

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
define( 'AUTH_KEY',          '3oSwI;YL+)#._(sKjpMS@s7UDZI^3 lD`w){Pzq]-`gR? ^_qIpnyOSvvz~ISj$8' );
define( 'SECURE_AUTH_KEY',   'uf=|*hwH/[vS;Xr#. F<#KAbB}b6GM#[Uv!*WLm~,zNh<,L}L4GwwV(;aT2!Ii!Y' );
define( 'LOGGED_IN_KEY',     ',[)5#,hFj}xz8|[!8r:ANlDsr)#P@bte[b/vXsq;wkP?renUK75!-&Ug9T63c|wS' );
define( 'NONCE_KEY',         '5e>X],xkL{-SxY;{A@F$7d}(HHir.dZ8?w]e,|[07vWX2xanW~2Zi(#e>W3*+}DQ' );
define( 'AUTH_SALT',         ';jm@rm?YG-wh6CuK:k kVuw~CNDH}9NV^Y_y$5Ilp+l&=EE7mq#Z3VVti4W;C8Hf' );
define( 'SECURE_AUTH_SALT',  '3[a8OU^[~LnlVvm;,>9}:eUk24-|2s_|c;txUJ)JJn1;N<(w7yzAE],#M&&~Qwry' );
define( 'LOGGED_IN_SALT',    '/oO&1Y:`cBOtL$:{;FFEV#t~x VTF:r$J_b=HWSw,o+HsBACJ3ypySnszQwJKHOZ' );
define( 'NONCE_SALT',        'tces6Y>}e_yj:Veu!p`TXSWTS,fi-{ DbO1&Km;&9]{`O)1<#8LpInDqQTbnkE)n' );
define( 'WP_CACHE_KEY_SALT', 'M&A)aghLc9#(8!o<M#Dx2Lm=D-NW4Ex|d2q+30kE<>1~?Fe`_JCd%)-v:3e8q}$y' );


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
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
