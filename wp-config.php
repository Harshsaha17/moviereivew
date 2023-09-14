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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
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
define( 'AUTH_KEY',         ':wLDh.Y;7L[D53,IwF/{[&bHG?*8^r[$L<mt4+stJ4nXdu23Vm5erhxl^.prX$%h' );
define( 'SECURE_AUTH_KEY',  '!PF 4&]0H7?${04Hi[FIsO|..G[FL~-Ut!/sV[FdLT+c}mI?34q+E>p%R~5L_n 7' );
define( 'LOGGED_IN_KEY',    'fXb/*kaOsi,f,ljkPO_Zx@Irm,K<i!||:|Xdi9^5)nEM.@UBIkn|iK~&+)uq<x<&' );
define( 'NONCE_KEY',        'og=z8r[wAI}7tp(tR-nv2nbY`r-`q$vKvJgf.XY*[~c1X3Y.>=4&^#;9![`Wxkqq' );
define( 'AUTH_SALT',        '}-uQ]~!W?zU}Uf.xG-3d5uHaP^tLPzfb<&7j02};I(#F6~=jR2;4X,U):`mF{#Ud' );
define( 'SECURE_AUTH_SALT', 'oQ|.3~%cbz?`7js,a?vZ,|Rl)+RWgJR^qu+1we{)Wd~CMes9KVWDE,Z6UU}*7<(b' );
define( 'LOGGED_IN_SALT',   'Gh2*o@=Q(&`aXW7Cw(Gkt33; D4^~$jTI4C(T|l8)_xFY~GjGt;|lWg8RHmgMN#i' );
define( 'NONCE_SALT',       ':o,EUvuTMWDc7WODGw{D]GRiNBH,au&,mJ8P$MT_ti8fng+|!>x9weBTMK27t-W~' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define('WP_MEMORY_LIMIT', '256M');


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
