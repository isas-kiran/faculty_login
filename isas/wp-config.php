<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'lahoo123_isas');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'ctrls.123!@#');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'S|G4e(^dW,?]5Z[<mSS*p|r<P,WP&.NH]//e!+]`LxVb^5 h3:eY&S@{x/*k,.cy');
define('SECURE_AUTH_KEY',  ' i/w^ FDs%!27X-8ZN]`,*#S+%&(]Q;T`FZ|)9o(.(exQoCUF81[<@&flJT,Eu!B');
define('LOGGED_IN_KEY',    'O1]I3A6P5J)wx$2_-Fj;o,z%Zpaxhl+:*(S<Kfox!X1NUv]kjU|[PhmFkp;U:(,b');
define('NONCE_KEY',        'tG;e/5{.F,p/`Tj`PHZ]h;6xUg#}Jx4,>2/_a18;f1G4v!W^>xKTPal~}C~|MmoI');
define('AUTH_SALT',        's=yt%5nWoaZbXyPc)1-r_z[R?]?`}4$20+d%tG$K[>>:}kX.,/?~g_>4fb*l*&Oj');
define('SECURE_AUTH_SALT', '>]0Nvh=-Ka6&Ule7.23qhm(EKOYDyM&5wk%CV;Dzq^%P8X?dmB~6);gYUWE459u@');
define('LOGGED_IN_SALT',   '+K,2M:$b/ko1V$FSP!qqF9ou^hR]]a~CI^_*SR}}wv$Ek<wT~b6XdJ5?r;9J[S8r');
define('NONCE_SALT',       '-)t4SHYNk<CBHBM<zqA3eKK(z5hga_dK9r{BZtM*)6,}T2hni!GbsAGqg]OoJw.1');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'isas_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
