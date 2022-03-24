<?php
/**
 * Template for FAQ Builder
 *
 * @package a-faq-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="faq-builder">
    <div class="faq-inner-wrapper">
        <h3 class="faq-title">Faq Title</h3>
        <ul class="faq-items">
            <?php
            if ( isset( $value['contents'] ) && ! empty( $value['contents'] ) && is_array( $value['contents'] ) && count( $value['contents'] ) > 0 ) :
                foreach( $value['contents'] as $key => $item ) :
                    $item_title = isset( $item['title'] ) ? $item['title'] : '';
                    $item_content = isset( $item['content'] ) ? $item['content'] : '';
                    if ( ! empty( $item_title ) && ! empty( $item_content ) ) :
                        ?>
                        <li id="faq-item-'<?php echo esc_attr( $key ); ?>" class="faq-item faq-item-'<?php echo esc_attr( $key ); ?>">
                            <div class="faq-item-inner">
                                <h3 class="faq-item-title"><?php echo esc_html( $item_title ); ?></h3>
                                <div class="faq-item-content">
                                    <p><?php echo esc_html( $item_content ); ?></p>
                                </div>
                            </div>
                        </li>
                        <?php
                    endif;
                endforeach;
            endif;
            ?>
        </ul>
    </div>
</div>