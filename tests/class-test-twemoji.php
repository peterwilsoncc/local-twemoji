<?php
/**
 * Test Template
 *
 * @package PWCC\LocalTwemoji\Tests
 */

namespace PWCC\LocalTwemoji\Tests;

use WP_UnitTestCase;

/**
 * Test the Local Twemoji plugin.
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
	 * Ensure the Twemoji version is correct.
	 */
	public function test_twemoji_version() {
		$actual = \PWCC\LocalTwemoji\TWEMOJI_VERSION;

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- OK for this test.
		$packages = json_decode( file_get_contents( __DIR__ . '/../package.json' ), true );
		$expected = $packages['devDependencies']['@twemoji/api'];

		/*
		 * Allow the actual version to have a forth .x segment.
		 *
		 * This is to cover situations in which a Twemoji update has gone wrong
		 * in the plugin and a quick fix is required that is not associated with a new
		 * Twemoji release.
		 */
		$actual_parts   = explode( '.', $actual );
		$actual_trimmed = implode( '.', array_slice( $actual_parts, 0, 3 ) );

		$this->assertSame( $expected, $actual_trimmed, 'Twemoji version should match the version in package.json' );
	}

	/**
	 * Test the plugin version constant matches the file header.
	 */
	public function test_plugin_version_constant() {
		$plugin_data = get_file_data(
			__DIR__ . '/../local-twemoji.php',
			array(
				'Version' => 'Version',
			)
		);

		$this->assertEquals(
			\PWCC\LocalTwemoji\PLUGIN_VERSION,
			$plugin_data['Version'],
			'Plugin version constant should match the file header'
		);
	}

	/**
	 * Test the emoji URL filter.
	 */
	public function test_emoji_url_filter() {
		$actual = get_echo( '_print_emoji_detection_script' );
		$flags  = 0;
		if ( version_compare( wp_get_wp_version(), '6.9-alpha', '>=' ) ) {
			$flags = JSON_HEX_TAG | JSON_UNESCAPED_SLASHES;
		}

		$default_url = wp_json_encode( 'https://s.w.org/images/core/emoji/', $flags );
		$default_url = rtrim( $default_url, '"' );

		$expected_url = wp_json_encode( home_url(), $flags );
		$expected_url = rtrim( $expected_url, '"' );

		$this->assertStringNotContainsString( $default_url, $actual, 's.w.org URL should not be present' );
		$this->assertStringContainsString( $expected_url, $actual, 'home url is expected to be present' );
	}
}
