<?php
/**
 * Local Twemoji
 *
 * @package           LocalTwemoji
 * @author            Peter Wilson
 * @copyright         2025 Peter Wilson
 * @license           MIT
 */

namespace PWCC\LocalTwemoji;

const PLUGIN_VERSION  = '1.0.0';
const TWEMOJI_VERSION = '16.0.1';

/**
 * Bootstrap the plugin.
 */
function bootstrap() {
	add_filter( 'emoji_url', __NAMESPACE__ . '\\filter_emoji_url' );
	add_filter( 'emoji_svg_url', __NAMESPACE__ . '\\filter_emoji_svg_url' );

	add_filter( 'emoji_ext', __NAMESPACE__ . '\\extension_cache_busting' );
	add_filter( 'emoji_svg_ext', __NAMESPACE__ . '\\extension_cache_busting' );
}

/**
 * Filter the base Twemoji URL.
 *
 * @return string[] The base Twemoji URL.
 */
function filter_emoji_url() {
	// Get the URL for the plugin.
	$plugin_url = plugin_dir_url( __DIR__ );
	return sanitize_url( $plugin_url . 'images/emoji/72x72/' );
}

/**
 * Filter the SVG Twemoji URL.
 */
function filter_emoji_svg_url() {
	// Get the URL for the plugin.
	$plugin_url = plugin_dir_url( __DIR__ );
	return sanitize_url( $plugin_url . 'images/emoji/svg/' );
}

/**
 * Add cache-busting query strings to emoji URLs.
 *
 * This is to ensure that browsers do not serve cached versions
 * of emoji images following an update to the plugin.
 *
 * The URL of the images does not change, so the Twemoji version
 * is appended as a query string parameter.
 *
 * @param string $ext The file extension of the emoji, either .svg or .png.
 * @return string The extension with the Twemoji version appended as a query string.
 */
function extension_cache_busting( $ext ) {
	/*
	 * Append the Twemoji version to the extension as a query string.
	 *
	 * As the extension is not a full URL it's not possible to use
	 * `sanitize_url()` here, so we use `sanitize_title()` to ensure
	 * that:
	 *
	 * - dots are converted to hyphens
	 * - typos are converted/removed to ensure a valid string
	 */
	return $ext . '?ver=' . sanitize_title( TWEMOJI_VERSION );
}
