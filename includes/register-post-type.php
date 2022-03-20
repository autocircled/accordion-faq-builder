<?php
namespace AFaqBuilder\Includes;
/**
 * Register Accordion FAQ Builder custom post type.
 *
 * @since      0.1
 *
 * @package    a-faq-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Custom post class to register the accordion.
 */
class Register_Post_Type {

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
		}
		return self::$instance;
	}

	/**
	 * Accordion FAQ Builder post type
	 */
	public function accordion_faq_builder_post_type() {

		if ( post_type_exists( 'accordion_faq' ) ) {
			return;
		}

		// Set the Accordion FAQ Builder post type labels.
		$labels = apply_filters(
			'a_faq_builder_post_type_labels',
			array(
				'name'               => esc_html_x( 'Accordion FAQs', 'a-faq-builder' ),
				'singular_name'      => esc_html_x( 'Accordion', 'a-faq-builder' ),
				'add_new'            => esc_html__( 'Add New', 'a-faq-builder' ),
				'add_new_item'       => esc_html__( 'Add Accordion FAQ', 'a-faq-builder' ),
				'edit_item'          => esc_html__( 'Edit Accordion FAQ', 'a-faq-builder' ),
				'new_item'           => esc_html__( 'New Accordion', 'a-faq-builder' ),
				'view_item'          => esc_html__( 'View Accordion', 'a-faq-builder' ),
				'search_items'       => esc_html__( 'Search Accordion FAQ', 'a-faq-builder' ),
				'not_found'          => esc_html__( 'No WP Accordion found.', 'a-faq-builder' ),
				'not_found_in_trash' => esc_html__( 'No WP Accordion found in trash.', 'a-faq-builder' ),
				'parent_item_colon'  => esc_html__( 'Parent Item:', 'a-faq-builder' ),
				'menu_name'          => esc_html__( 'Accordion FAQ Builder', 'a-faq-builder' ),
				'all_items'          => esc_html__( 'Accordion FAQs', 'a-faq-builder' ),
			)
		);

		// Base 64 encoded SVG image.
		$menu_icon = 'data:image/svg+xml;base64,' . base64_encode(
			'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
			<style type="text/css">
				.st0{fill:#A0A5AA;}
			</style>
			<g>
				<path class="st0" d="M0,128v256h512V128H0z M480,352H32V224h448V352z"/>
				<path class="st0" d="M0,0h512v96H0V0z"/>
				<path class="st0" d="M0,416h512v96H0V416z"/>
			</g>
			</svg>'
		);

		// Set the Accordion FAQ Builder post type arguments.
		$args = apply_filters(
			'a_faq_builder_post_type_args',
			array(
				'labels'              => $labels,
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'exclude_from_search' => true,
				'menu_position'       => apply_filters( 'a_faq_builder_menu_position', 116 ),
				'show_in_admin_bar'   => false,
				'query_var'           => false,
				'rewrite'             => false,
				'menu_icon'           => 'dashicons-image-filter',
				'supports'            => array(
					'title',
				),
			)
		);
		register_post_type( 'accordion_faq', $args );
	}
}