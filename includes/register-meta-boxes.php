<?php
/**
 * Register meta boxes for Accordion Post type
 */
namespace AFaqBuilder\Includes;

use \AFaqBuilder\Includes\Helper;
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
            __( 'Add Accordion FAQ', 'a-faq-builder' ),
            [ Register_Meta_Boxes::class, 'accordion_content_meta_box_callback' ],
            'accordion_faq'
        );
    }

    public function accordion_content_meta_box_callback( $post ) {

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'accordion_content_nonce', 'accordion_content_nonce' );
    
        $value = get_post_meta( $post->ID, '_accordion_content', true );
        var_dump($value);
        $type = isset( $value['type'] ) && ! empty( $value['type'] ) ? $value['type'] : false;
    
        ?>
        <div class="accordion-content-wrapper">
            <header class="meta-box-header">
                <h3 class="section-title"><?php echo esc_html__( 'Accordion Type', 'sss' ); ?></h3>
                <ul>
                    <li>
                        <input type="radio" name="accordion_builder[type]" id="accordion-type-content" value="content" <?php echo $type && 'content' === $type ? esc_attr( 'checked' ) : ''; ?> >
                        <label for="accordion-type-content"><?php echo esc_html__( 'Content', 'a-faq-builder' ); ?></label>
                    </li>
                    <li>
                        <input type="radio" name="accordion_builder[type]" id="accordion-type-post" value="post" <?php echo $type && 'post' === $type ? esc_attr( 'checked' ) : ''; ?>>
                        <label for="accordion-type-post"><?php echo esc_html__( 'Post', 'a-faq-builder' ); ?></label>
                    </li>
                </ul>
            </header>
            <div class="content-area">
                <div class="clonable-content" style="display: none;">
                    <li id="clonable-item" class="accordion-item accordion-clonable-item">
                        <div class="accordion-item-wrapper">
                            <h3 class="item-counter"><?php echo esc_html__( 'Item #', 'sss' ); ?></h3>
                            <div class="row">
                                <label for="accordion_builder[contents][#][title]"><?php echo esc_html__( 'Title', 'sss' ); ?></label>
                                <input type="text" id="accordion_builder[contents][#][title]" name="accordion_builder[contents][#][title]" value="">
                            </div>
                            <div class="row">
                                <label for="accordion_builder[contents][#][content]"><?php echo esc_html__( 'Content', 'sss' ); ?></label>
                                <textarea style="width:100%" id="accordion_builder[contents][#][content]" name="accordion_builder[contents][#][content]" rows="5"></textarea>
                            </div>
                        </div>
                    </li>
                </div>
                <ul id="accordion-items" class="accordion-items">
                    
                </ul>
                <a href="#" id="add-new-item" class="button button-primary button-large"><?php echo esc_html__( 'Add new item', 'sss' ); ?></a>
            </div>
        </div>
        <?php
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
// var_dump($_POST);
        /* OK, it's safe for us to save the data now. */

        // Make sure that it is set.
        if ( ! isset( $_POST['accordion_builder'] ) ) {
            return;
        }

        // Sanitize user input.
        $my_data = Helper::recursive_sanitize_text_field( $_POST['accordion_builder'] );

        // Update the meta field in the database.
        update_post_meta( $post_id, '_accordion_content', $my_data );
    }
}
