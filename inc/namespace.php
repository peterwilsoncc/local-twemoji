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

use PWCC\LocalTwemoji\Generated;

const PLUGIN_VERSION = '1.0.0';

/**
 * Bootstrap the plugin.
 */
function bootstrap() {
	add_filter( 'emoji_url', __NAMESPACE__ . '\\filter_emoji_url' );
	add_filter( 'emoji_svg_url', __NAMESPACE__ . '\\filter_emoji_svg_url' );
	add_filter( 'script_loader_src', __NAMESPACE__ . '\\filter_twemoji_src', 10, 2 );
	add_filter( 'script_loader_src', __NAMESPACE__ . '\\filter_wpemoji_src', 10, 2 );
	add_filter( 'script_loader_src', __NAMESPACE__ . '\\filter_concat_src', 10, 2 );
}

/**
 * Filters the Twemoji script loader source.
 *
 * @param string $src    Script loader source path.
 * @param string $handle Script handle.
 * @return string Script loader source path.
 */
function filter_twemoji_src( $src, $handle ) {
	if ( 'twemoji' !== $handle ) {
		return $src;
	}

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// Get the URL for the JavaScript file.
	$plugin_url = plugin_dir_url( __DIR__ );
	$src        = $plugin_url . "js/twemoji{$suffix}.js";

	$version = Generated\get_twemoji_version();
	if ( $version ) {
		$src = add_query_arg( 'ver', $version, $src );
	}
	return $src;
}

/**
 * Filters the wp-emoji script loader source.
 *
 * @param string $src    Script loader source path.
 * @param string $handle Script handle.
 * @return string Script loader source path.
 */
function filter_wpemoji_src( $src, $handle ) {
	if ( 'wpemoji' !== $handle ) {
		return $src;
	}

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// Get the URL for the JavaScript file.
	$plugin_url = plugin_dir_url( __DIR__ );
	$src        = $plugin_url . "js/wp-emoji{$suffix}.js";

	$version = PLUGIN_VERSION;
	if ( $version ) {
		$src = add_query_arg( 'ver', $version, $src );
	}
	return $src;
}

/**
 * Filters the wp-emoji script loader source.
 *
 * @param string $src    Script loader source path.
 * @param string $handle Script handle.
 * @return string Script loader source path.
 */
function filter_concat_src( $src, $handle ) {
	if ( 'concatemoji' !== $handle ) {
		return $src;
	}

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// Get the URL for the JavaScript file.
	$plugin_url = plugin_dir_url( __DIR__ );
	$src        = $plugin_url . "js/wp-emoji-concat{$suffix}.js";

	$version = PLUGIN_VERSION . '-' . Generated\get_twemoji_version();
	if ( $version ) {
		$src = add_query_arg( 'ver', $version, $src );
	}
	return $src;
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
