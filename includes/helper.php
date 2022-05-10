<?php
/**
 * Helper Class
 *
 * @since      0.1
 *
 * @package    a-faq-builder
 */

namespace AFaqBuilder\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Helper {

	public static $defaults = array(
		'id' => 0,
		'position' => 'vertical',
		'type' => 'content',
	);

	/**
	 * Recursive sanitation for an array
	 *
	 * @link https://wordpress.stackexchange.com/a/255238
	 * @param $array
	 *
	 * @return mixed
	 */
	public static function recursive_sanitize_text_field( $array ) {
		foreach ( $array as $key => &$value ) {
			if ( is_array( $value ) ) {
				$value = self::recursive_sanitize_text_field( $value );
			}
			else {
				if ( 'content' === $key ){
					$value = wp_kses( $value, self::allowed_html_tag() );
				} else {
					$value = sanitize_text_field( $value );
				}
			}
		}

		return $array;
	}

	/**
	 * Iframe allowed for Youtube Video
	 *
	 * @since 0.2
	 * @return array
	 */
	public static function allowed_html_tag() {
		global $allowedposttags;

		$iframe = array(
			'iframe' => array(
				'src' => array (),
				'width' => array (),
				'height' => array (),
				'title' => array(),
				'allow' => array(),
				'frameborder' => array(),
				'allowFullScreen' => array() // add any other attributes you wish to allow
			)
		);

		$allowed_html = array_merge( $allowedposttags, $iframe );
		return $allowed_html;
	}
}
