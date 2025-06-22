<?php
/**
 * Test Template
 *
 * @package PWCC\LocalTwemoji\Tests
 */

namespace PWCC\LocalTwemoji\Tests;

use WP_UnitTestCase;

/**
 * Sample Tests
 */
class Test_Twemoji extends WP_UnitTestCase {
	/**
	 * Test that the plugin is loaded.
	 */
	public function test_plugin_loaded() {
		$this->assertNotEmpty( \PWCC\LocalTwemoji\PLUGIN_VERSION );
	}

	/**
	 * Test the plugin version uses semantic versioning.
	 */
	public function test_semantic_versioning() {
		$version = \PWCC\LocalTwemoji\PLUGIN_VERSION;
		$this->assertMatchesRegularExpression( '/^\d+\.\d+\.\d+$/', $version, 'Plugin version should be in the format X.Y.Z' );
	}

	/**
	 * Test the emoji URL filter.
	 */
	public function test_emoji_url_filter() {
		$actual = get_echo( '_print_emoji_detection_script' );

		$default_url = wp_json_encode( 'https://s.w.org/images/core/emoji/' );
		$default_url = rtrim( $default_url, '"' );

		$expected_url = wp_json_encode( home_url() );
		$expected_url = rtrim( $expected_url, '"' );

		$this->assertStringNotContainsString( $default_url, $actual, 's.w.org URL should not be present' );
		$this->assertStringContainsString( $expected_url, $actual, 'home url is expected to be present' );
	}
}
