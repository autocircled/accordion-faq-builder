<?php
/**
 * Register meta boxes for Accordion Post type
 *
 * @package a-faq-builder
 */
namespace AFaqBuilder\Includes;

use \AFaqBuilder\Includes\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Shortcode {
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
        add_shortcode( 'FAQ_Builder', [ $this, 'faq_builder_shortcode_generator' ] );
    }

    public function faq_builder_shortcode_generator( $atts = array() ) {
        $atts = array_change_key_case( $atts );
        $args = shortcode_atts(
            Helper::$defaults, $atts
        );
        // var_dump($atts, $args);
        $value = get_post_meta( $args['id'], '_accordion_content', true );
        // var_dump($value);

        if ( isset( $value['type'] ) && 'content' === $value['type'] ) {
            include 'templates/content.php';
        }
        if ( isset( $value['type'] ) && 'post' === $value['type'] ) {
            include 'templates/post.php';
        }
    }
}
