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
				$value = sanitize_text_field( $value );
			}
		}

		return $array;
	}
}
