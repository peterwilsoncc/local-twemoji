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
	 * Ensure the Twemoji version is correct.
	 */
	public function test_twemoji_version() {
		$actual = \PWCC\LocalTwemoji\TWEMOJI_VERSION;

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- OK for this test.
		$packages = json_decode( file_get_contents( __DIR__ . '/../package.json' ), true );
		$expected = $packages['devDependencies']['@twemoji/api'];

		$this->assertSame( $expected, $actual, 'Twemoji version should match the version in package.json' );
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

		$default_url = wp_json_encode( 'https://s.w.org/images/core/emoji/' );
		$default_url = rtrim( $default_url, '"' );

		$expected_url = wp_json_encode( home_url() );
		$expected_url = rtrim( $expected_url, '"' );

		$this->assertStringNotContainsString( $default_url, $actual, 's.w.org URL should not be present' );
		$this->assertStringContainsString( $expected_url, $actual, 'home url is expected to be present' );
	}
}
