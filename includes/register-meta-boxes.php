<?php
/**
 * Register meta boxes for Accordion Post type
 */
namespace AFaqBuilder\Includes;

class Register_Meta_Boxes {

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

    /**
	 * Setup necessary settings
	 *
	 * @since 0.1
	 */
    protected function setup() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
        add_action( 'save_post', [ $this, 'save_accordion_content_meta_box_data' ] );
    }
    
    public function add_meta_boxes() {
        add_meta_box(
            'accordion-content',
            __( 'Add Accordion FAQ', 'sitepoint' ),
            [ Register_Meta_Boxes::class, 'accordion_content_meta_box_callback' ],
            'accordion_faq'
        );
    }

    public function accordion_content_meta_box_callback( $post ) {

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'accordion_content_nonce', 'accordion_content_nonce' );
    
        $value = get_post_meta( $post->ID, '_accordion_content', true );
    
        echo '<textarea style="width:100%" id="accordion_content" name="accordion_content">' . esc_attr( $value ) . '</textarea>';
    }

    /**
    * When the post is saved, saves our custom data.
    *
    * @param int $post_id
    */
    public function save_accordion_content_meta_box_data( $post_id ) {

        // Check if our nonce is set.
        if ( ! isset( $_POST['accordion_content_nonce'] ) ) {
            return;
        }

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['accordion_content_nonce'], 'accordion_content_nonce' ) ) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'accordion_faq' == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }

        }

        /* OK, it's safe for us to save the data now. */

        // Make sure that it is set.
        if ( ! isset( $_POST['accordion_content'] ) ) {
            return;
        }

        // Sanitize user input.
        $my_data = sanitize_text_field( $_POST['accordion_content'] );

        // Update the meta field in the database.
        update_post_meta( $post_id, '_accordion_content', $my_data );
    }
}
