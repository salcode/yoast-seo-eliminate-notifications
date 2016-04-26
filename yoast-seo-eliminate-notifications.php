<?php
/**
 * Plugin Name: Yoast SEO Eliminate Notifications
 * Plugin URI: https://salferrarello.com/yoast-seo-eliminate-notifications/
 * Description: Suppresses the Yoast SEO messages to "Take the Tour" and see "What's New". Tested on Yoast SEO 3.2.3
 * Version: 0.2.0
 * Author: Sal Ferrarello
 * Author URI: https://salferrarello.com/
 * Text Domain: yoast-seo-eliminate-notifications
 * Domain Path: /languages
 *
 * @package yoast-seo-eliminate-notifications
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'get_user_metadata', 'salcode_yoast_seo_eliminate_notifications', 10, 4 );

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
function salcode_yoast_seo_eliminate_notifications( $value, $object_id, $meta_key, $single ) {

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
