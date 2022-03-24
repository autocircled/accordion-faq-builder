<?php
/**
 * Enqueue style and scripts
 *
 * @since      0.1
 *
 * @package    a-faq-builder
 */
namespace AFaqBuilder\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Enqueue_Script {

    private static $instance;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since 0.1
	 * @static
	 * @return self Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->setup();
		}
		return self::$instance;
	}

    protected function setup() {
        add_action( 'admin_enqueue_scripts', [ $this, 'load_scripts' ] );
    }

    public function load_scripts() {
        wp_enqueue_script( 'shortable', trailingslashit( AFAQBUILDER_URL ) . 'assets/js/Sortable.js', array(), '1.15.0', true );
        wp_enqueue_script( 'a_faq_builder_admin_script', trailingslashit( AFAQBUILDER_URL ) . 'assets/js/admin-script.js', array( 'shortable' ), AFAQBUILDER_VERSION, true );
    }
}
