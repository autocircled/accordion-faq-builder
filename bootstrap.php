<?php
namespace AFaqBuilder;

use \AFaqBuilder\Modules\Register_Post_Type;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Bootstrap {

    /**
	 * Holds class object
	 *
	 * @var   object
	 * @since 0.1
	 */
	private static $instance;

    public function __construct() {
        add_action( 'init', [ Register_Post_Type::class, 'accordion_faq_builder_post_type' ] );
    }

    public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}