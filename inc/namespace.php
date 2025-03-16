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

/**
 * Bootstrap the plugin.
 */
function bootstrap() {
	add_filter( 'emoji_url', __NAMESPACE__ . '\\filter_emoji_url' );
	add_filter( 'emoji_svg_url', __NAMESPACE__ . '\\filter_emoji_svg_url' );
	add_filter( 'script_loader_src', __NAMESPACE__ . '\\filter_script_loader_src', 10, 2 );
}

/**
 * Filters the script loader source.
 *
 * @param string $src    Script loader source path.
 * @param string $handle Script handle.
 * @return string Script loader source path.
 */
function filter_script_loader_src( $src, $handle ) {
	if ( 'twemoji' !== $handle ) {
		return $src;
	}

	// Get the URL for the JavaScript file.
	$plugin_url = plugin_dir_url( __DIR__ );
	$src        = $plugin_url . 'js/twemoji.js';

	$version = Generated\get_twemoji_version();
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
