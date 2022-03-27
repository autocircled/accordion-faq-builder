<?php
/**
 * Register meta boxes for Accordion Post type
 *
 * @since      0.1
 *
 * @package    a-faq-builder
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
        add_action( 'save_post', [ $this, 'save_afb_content_meta_box_data' ] );
        add_filter('manage_accordion_faq_posts_columns', function( $columns ) {
            return array_merge( $columns, ['shortcode' => __('Shortcode', 'a-faq-builder')] );
        });
        add_action('manage_accordion_faq_posts_custom_column', [ $this, 'shortcode_genarator' ], 10, 2);
    }
    
    public function add_meta_boxes() {
        add_meta_box(
            'afb-content',
            __( 'Add Accordion FAQ', 'a-faq-builder' ),
            [ Register_Meta_Boxes::class, 'afb_content_meta_box_callback' ],
            'accordion_faq'
        );
    }

    public function afb_content_meta_box_callback( $post ) {

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'afb_content_nonce', 'afb_content_nonce' );
    
        $value = get_post_meta( $post->ID, '_afb_content', true );

        $type = isset( $value['type'] ) && ! empty( $value['type'] ) ? $value['type'] : Helper::$defaults['type'];
        $contents = isset( $value['contents'] ) && ! empty( $value['contents'] ) && is_array( $value['contents'] ) ? $value['contents'] : array(); 
        ?>
        <div class="afb-content-wrapper">
            <header class="meta-box-header">
                <h3 class="section-title"><?php echo esc_html__( 'Accordion Type', 'a-faq-builder' ); ?></h3>
                <ul>
                    <li>
                        <input type="radio" name="afb_data[type]" id="afb-type-content" value="content" <?php echo $type && 'content' === $type ? esc_attr( 'checked' ) : ''; ?> >
                        <label for="afb-type-content"><?php echo esc_html__( 'Content', 'a-faq-builder' ); ?></label>
                    </li>
                    <li>
                        <input type="radio" name="afb_data[type]" id="afb-type-post" value="post" <?php echo $type && 'post' === $type ? esc_attr( 'checked' ) : ''; ?>>
                        <label for="afb-type-post"><?php echo esc_html__( 'Post', 'a-faq-builder' ); ?></label>
                    </li>
                </ul>
            </header>
            <div class="content-area">
                <div class="clonable-content" style="display: none;">
                    <li id="clonable-item" class="afb--item afb-clonable-item">
                        <div class="afb--item-wrapper">
                            <div class="item-header">
                                <div class="afb--ls">
                                    <h3 class="item-counter"><?php echo esc_html__( 'Item #', 'a-faq-builder' ); ?></h3>
                                </div>
                                <div class="afb--rs">
                                    <span class="dashicons dashicons-move handle"></span>
                                    <!-- <span class="dashicons dashicons-arrow-up move-up"></span>
                                    <span class="dashicons dashicons-arrow-down move-down"></span>
                                    <span class="dashicons dashicons-editor-code expand-handle"></span> -->
                                </div>
                            </div>
                            <div class="item-body">
                                <div class="row">
                                    <label data-target="title-label"><?php echo esc_html__( 'Title', 'a-faq-builder' ); ?></label>
                                    <input type="text" data-target="title-input">
                                </div>
                                <div class="row">
                                    <label data-target="content-label"><?php echo esc_html__( 'Content', 'a-faq-builder' ); ?></label>
                                    <textarea style="width:100%" rows="5" data-target="content-input"></textarea>
                                </div>
                            </div>
                        </div>
                    </li>
                </div>
                <ul id="afbItems" class="afb--items">
                    <?php
                    if ( count( $contents ) > 0 ) {
                        foreach( $contents as $key => $val ) {
                            $title = isset( $val['title'] ) && ! empty( $val['title'] ) ? $val['title'] : '';
                            $content = isset( $val['content'] ) ? $val['content'] : '';
                            ?>
                            <li id="item-<?php echo esc_attr( $key ); ?>" class="afb--item afb--item-<?php echo esc_attr( $key ); ?> expanded" data-id="<?php echo esc_attr( $key ); ?>">
                                <div class="afb--item-wrapper">
                                    <div class="item-header">
                                        <div class="afb--ls">
                                            <h3 class="item-counter"><?php echo empty( $title ) ? esc_html__( 'New Item', 'a-faq-builder' ) : esc_html( $title ); ?></h3>
                                        </div>
                                        <div class="afb--rs">
                                            <span class="hover-control">
                                                <span class="dashicons dashicons-admin-page clone"></span>
                                                <span class="dashicons dashicons-trash trash"></span>
                                            </span>
                                            <span class="dashicons dashicons-move handle"></span>
                                            <span class="dashicons dashicons-arrow-up move-up"></span>
                                            <span class="dashicons dashicons-arrow-down move-down"></span>
                                            <span class="dashicons dashicons-editor-code expand-handle"></span>
                                        </div>
                                    </div>
                                    <div class="item-body">
                                        <div class="row">
                                            <label data-target="title-label" for="afb_data[contents][<?php echo esc_attr( $key ); ?>][title]">Title</label>
                                            <input type="text" data-target="title-input" id="afb_data[contents][<?php echo esc_attr( $key ); ?>][title]" name="afb_data[contents][<?php echo esc_attr( $key ); ?>][title]" value="<?php echo esc_attr( $title ); ?>">
                                        </div>
                                        <div class="row">
                                            <label data-target="content-label" for="afb_data[contents][<?php echo esc_attr( $key ); ?>][content]">Content</label>
                                            <textarea style="width:100%" rows="5" data-target="content-input" id="afb_data[contents][<?php echo esc_html( $key ); ?>][content]" name="afb_data[contents][<?php echo esc_attr( $key ); ?>][content]"><?php echo wp_kses_post( $content ); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <a href="#" id="add-new-faq-item" class="button button-primary button-large" data-next="<?php echo esc_attr( count( $contents ) ); ?>"><?php echo esc_html__( 'Add new item', 'a-faq-builder' ); ?></a>
            </div>
        </div>
        <?php
    }

    /**
    * When the post is saved, saves our custom data.
    *
    * @param int $post_id
    */
    public function save_afb_content_meta_box_data( $post_id ) {

        // Check if our nonce is set.
        if ( ! isset( $_POST['afb_content_nonce'] ) ) {
            return;
        }

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['afb_content_nonce'], 'afb_content_nonce' ) ) {
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
        if ( ! isset( $_POST['afb_data'] ) ) {
            return;
        }
        if ( ! isset( $_POST['afb_data']['contents'] ) ) {
            return;
        }

        // Sorting faq items if they need to be sorted
        $sorted_values = array_map( function( $v ){ return $v; }, array_values( $_POST['afb_data']['contents'] ) );

        // Re-assigning sorted faq items into original array
        $_POST['afb_data']['contents'] = $sorted_values;

        // Sanitize user input.
        $afb_data = Helper::recursive_sanitize_text_field( $_POST['afb_data'] );

        // Update the meta field in the database.
        update_post_meta( $post_id, '_afb_content', $afb_data );
    }

    public function shortcode_genarator( $column_key, $post_id ) {
        if ($column_key == 'shortcode') {
                echo '<code id="afb-shortcode-'. esc_attr( $post_id ) .'">[A_FAQ_Builder id="' . esc_attr( $post_id ) . '"]</code>';
        }
    }
}
