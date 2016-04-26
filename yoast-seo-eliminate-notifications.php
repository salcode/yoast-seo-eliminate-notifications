<?php
/**
 * Plugin Name: Yoast SEO Suppress Messages
 * Plugin URI: http://salferrarello.com/yoast-seo-suppress-messages/
 * Description: Suppresses the Yoast SEO messages to "Take the Tour" and see "What's New". Tested on Yoast SEO 3.2.3
 * Version: 0.1.1
 * Author: Sal Ferrarello
 * Author URI: http://salferrarello.com/
 * Text Domain: yoast-seo-suppress-messages
 * Domain Path: /languages
 *
 * @package yoast-seo-suppress-messages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'get_user_metadata', 'salcode_yoast_seo_suppress_messages', 10, 4 );

/**
 * Modify Yoast SEO user meta values
 *
 * @param null|array|string $value     The value get_metadata() should return - a single metadata value,
 *                                     or an array of values.
 * @param int               $object_id Object ID.
 * @param string            $meta_key  Meta key.
 * @param bool              $single    Whether to return only the first value of the specified $meta_key.
 *
 * @return null|string      returns the override value for Yoast SEO meta_keys and the original
 *                          value (e.g. null) for all other meta_keys
 */
function salcode_yoast_seo_suppress_messages( $value, $object_id, $meta_key, $single ) {

	/**
	 * Suppress the tour message popup.
	 */
	if ( 'wpseo_ignore_tour' === $meta_key ) {
		return '1';
	}
	/**
	 * Suppress the After Update Notice, Find Out What's New admin notice.
	 */
	if ( 'wpseo_seen_about_version' === $meta_key ) {
		return '9999.0.0';
	}

	return $value;
}
