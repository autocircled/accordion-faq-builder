<?php
/**
 * Register meta boxes for Accordion Post type
 */
namespace AFaqBuilder\Includes;
use \AFaqBuilder\Includes\Helper;

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

        $args = wp_parse_args(
            $atts, Helper::$defaults
        );
        // var_dump($atts, $args);
        $value = get_post_meta( $args['id'], '_accordion_content', true );
        var_dump($value);

        $item_html = '';
        if ( isset( $value['contents'] ) && ! empty( $value['contents'] ) && is_array( $value['contents'] ) && count( $value['contents'] ) > 0 ) {
            // We are safe now
            foreach( $value['contents'] as $key => $item ) {
                $item_title = isset( $item['title'] ) ? $item['title'] : '';
                $item_content = isset( $item['content'] ) ? $item['content'] : '';
                if ( ! empty( $item_title ) && ! empty( $item_content ) ) {
                    $item_html .= '<li id="faq-item-' . esc_attr( $key ) . '" class="faq-item faq-item-' . esc_attr( $key ) . '">';
                    $item_html .= '<div class="faq-item-inner">';
                    $item_html .= '<h3 class="faq-item-title">' . esc_html( $item_title ) . '</h3>';
                    $item_html .= '<div class="faq-item-content">';
                    $item_html .= '<p>' . esc_html( $item_content ) . '</p>';
                    $item_html .= '</div>';
                    $item_html .= '</div>';
                    $item_html .= '</li>';
                }
            }
        }

        $html = <<<EOT
        <div class="faq-builder">
            <div class="faq-inner-wrapper">
                <h3 class="faq-title">Faq Title</h3>
                <ul class="faq-items">
                    {$item_html}
                </ul>
            </div>
        </div>
EOT;
        return $html;
    }
}
