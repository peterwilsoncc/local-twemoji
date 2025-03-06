<?php
/**
 * Local Twemoji
 *
 * @package           LocalTwemoji
 * @author            Peter Wilson
 * @copyright         2023 Peter Wilson
 * @license           MIT
 */

namespace PWCC\LocalTwemoji;

/**
 * Bootstrap the plugin.
 */
function bootstrap() {
	add_filter( 'emoji_url', __NAMESPACE__ . '\\filter_emoji_url' );
	add_filter( 'emoji_svg_url', __NAMESPACE__ . '\\filter_emoji_svg_url' );
}

/**
 * Filters the URL where emoji SVG images are hosted.
 *
 * @param string $url The emoji base URL for svg images.
 * @return string The emoji base URL for svg images.
 */
function filter_emoji_svg_url( $url ) {
	return $url;
}

/**
 * Filter the base Twemoji URL.
 *
 * @return string[] The base Twemoji URL.
 */
function filter_emoji_url() {
	// Get the URL for the plugin.
	$plugin_url = plugin_dir_url( __DIR__ );
	return $plugin_url . 'images/emoji/72x72/';
}

/**
 * Filter the SVG Twemoji URL.
 */
function filter_emoji_svg_url() {
	// Get the URL for the plugin.
	$plugin_url = plugin_dir_url( __DIR__ );
	return $plugin_url . 'images/emoji/svg/';
}
