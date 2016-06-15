<?php
/**
 * Plugin Name: Yoast SEO Eliminate Notifications
 * Plugin URI: https://salferrarello.com/yoast-seo-eliminate-notifications/
 * Description: Suppresses the Yoast SEO messages to "Take the Tour" and see "What's New". Tested on Yoast SEO 3.2.3, 3.3.0
 * Version: 0.3.0
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
add_filter( 'get_user_option_yoast_notifications', 'salcode_get_user_option_yoast_notifications' );
add_action( 'admin_init', 'remove_yoast_gsc_notification', 5 );

/**
 * Return no Yoast stored notifications.
 *
 * @param Yoast_Notification[] Array of Yoast Notifications.
 * @return array An empty array.
 */
function salcode_get_user_option_yoast_notifications( $notifications ) {
	return array();
}

/**
 * Remove method that registers Google Search Console Notification.
 *
 * This notification is a hard coded check, rather than a read from the database,
 * that checks if you have Google Search Console configured with the plugin.
 * Since we can't remove the hard-coded check, we remove the method that
 * registers the notification.
 */
function remove_yoast_gsc_notification() {
	global $wp_filter;

	$hook_name = 'admin_init';
	$class_name_method_belongs_to = 'WPSEO_GSC';
	$method_to_remove = 'register_gsc_notification';
	$priority = 10;

	$hooked_items = $wp_filter[$hook_name];

	foreach( $hooked_items[$priority] as $key => $callback ) {

		if ( false !== strpos( $key, $method_to_remove ) ) {
			if ( is_array( $callback['function'] )) {
				$object = $callback['function'][0];
				$method = $callback['function'][1];

				if (
					is_a( $object, $class_name_method_belongs_to )
					&& $method === $method_to_remove
				) {
					remove_filter(
						$hook_name,
						array(
							$object,
							$method
						),
						$priority
					);
				}
			}
		}
	}
}

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

if ( ! function_exists( 'salcode_yoast_seo_eliminate_notifications' ) ) {
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
}
