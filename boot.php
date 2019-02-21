<?php
/**
 * Load Freemius module.
 *
 * @author Webcraftic <wordpress.webraftic@gmail.com>, Alex Kovalev <alex.kovalevv@gmail.com> *
 * @copyright (c) 2018, Webcraftic Ltd
 *
 * @package core
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'FACTORY_FREEMIUS_000_LOADED' ) ) {
	return;
}

define( 'FACTORY_FREEMIUS_000_LOADED', true );
define( 'FACTORY_FREEMIUS_000_DIR', dirname( __FILE__ ) );
define( 'FACTORY_FREEMIUS_000_URL', plugins_url( null, __FILE__ ) );

#comp merge
// Freemius
require_once( FACTORY_FREEMIUS_000_DIR . '/includes/entities/class-freemius-entity.php' );
require_once( FACTORY_FREEMIUS_000_DIR . '/includes/entities/class-freemius-scope-entity.php' );
require_once( FACTORY_FREEMIUS_000_DIR . '/includes/entities/class-freemius-user.php' );
require_once( FACTORY_FREEMIUS_000_DIR . '/includes/entities/class-freemius-site.php' );

if ( ! class_exists( 'Freemius_Api_WordPress' ) ) {
	require_once FACTORY_FREEMIUS_000_DIR . '/includes/sdk/FreemiusWordPress.php';
}
require_once( FACTORY_FREEMIUS_000_DIR . '/includes/entities/class-freemius-license.php' );

require_once( FACTORY_FREEMIUS_000_DIR . '/includes/class-storage.php' );
require_once( FACTORY_FREEMIUS_000_DIR . '/ajax/check-license.php' );
#endcomp
