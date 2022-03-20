<?php
/**
 * Plugin Name: Accordion FAQ Builder
 * Plugin URI: https://devhelp.us
 * Description: Accordion FAQ Builder is a free unlimited FAQ builder plugin.
 * Version: 0.1
 * Author: autocircled
 * Text Domain: a-faq-builder
 *
 * @package a-faq-builder
 */

use \AFaqBuilder\Bootstrap;
use \AFaqBuilder\Autoloader;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! defined( 'AFAQBUILDER_FILE' ) ) {
    define( 'AFAQBUILDER_FILE', __FILE__ );
}

if ( ! defined( 'AFAQBUILDER_BASENAME' ) ) {
	define( 'AFAQBUILDER_BASENAME', plugin_basename( AFAQBUILDER_FILE ) );
}

if ( ! defined( 'AFAQBUILDER_DIR' ) ) {
	define( 'AFAQBUILDER_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'AFAQBUILDER_URL' ) ) {
	define( 'AFAQBUILDER_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'AFAQBUILDER_NAMESPACE' ) ) {
	define( 'AFAQBUILDER_NAMESPACE', 'AFaqBuilder' );
}

if ( ! defined( 'AFAQBUILDER_VERSION' ) ) {
	define( 'AFAQBUILDER_VERSION', '0.1' );
}

// Run autoloader
require_once __DIR__ . '/autoloader.php';
Autoloader::run();

// $activate_and_deactivate_action = [ Module::class, 'on_activate_and_deactivate_plugin' ];
// register_activation_hook( __FILE__, $activate_and_deactivate_action );
// register_deactivation_hook( __FILE__, $activate_and_deactivate_action );

// Bootstrap the plugin
Bootstrap::instance();