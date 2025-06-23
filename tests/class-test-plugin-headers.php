<?php
/**
 * Test Plugin Readme and PHP Headers
 *
 * @package PWCC\LocalTwemoji\Headers
 */

namespace PWCC\LocalTwemoji\Headers;

use WP_UnitTestCase;

/**
 * Sample Tests
 */
class Test_Plugin_Headers extends WP_UnitTestCase {

	/**
	 * Readme headers specification
	 *
	 * @var string[] Headers defined in the readme spec. Key: Header, Value: true: required, false: optional.
	 */
	public static $readme_headers = array(
		'Contributors'      => true,
		'Donate link'       => false,
		'Requires at least' => true, // Not required by the spec but I'm enforcing it.
		'Tested up to'      => true,
		'Stable tag'        => true,
		'Requires PHP'      => false,
		'License'           => true,
		'License URI'       => false,
	);

	/**
	 * Plugin headers specification
	 *
	 * @var string[] Headers defined in the plugin spec. Key: Header, Value: true: required, false: optional.
	 */
	public static $plugin_headers = array(
		'Plugin Name'       => true,
		'Plugin URI'        => false,
		'Description'       => true,
		'Version'           => true,
		'Requires at least' => true, // Not required by the spec but I'm enforcing it.
		'Requires PHP'      => true, // Not required by the spec but I'm enforcing it.
		'Author'            => true,
		'Author URI'        => false,
		'License'           => true,
		'License URI'       => false,
		'Text Domain'       => false,
		'Domain Path'       => false,
		'Network'           => false,
		'Update URI'        => false,
		'Requires Plugins'  => false,
	);

	/**
	 * Headers defined in the plugins readme.text file.
	 *
	 * @var string[] Headers defined in the readme spec Header => value.
	 */
	public static $defined_readme_headers = array();

	/**
	 * Headers defined in the plugin file.
	 *
	 * @var string[] Headers defined in the plugin spec Header => value.
	 */
	public static $defined_plugin_headers = array();

	/**
	 * Set up shared fixtures.
	 */
	public static function wpSetupBeforeClass() {
		// Get the readme headers.
		$readme_file_data = array();
		foreach ( self::$readme_headers as $header => $required ) {
			$readme_file_data[ $header ] = $header;
		}
		self::$defined_readme_headers = get_file_data(
			__DIR__ . '/../readme.txt',
			$readme_file_data
		);
		self::$defined_readme_headers = array_filter( self::$defined_readme_headers );

		// Get the plugin headers.
		// Plugin name.
		$plugin_file_name = basename( dirname( __DIR__ ) ) . '.php';
		if ( ! file_exists( __DIR__ . "/../{$plugin_file_name}" ) ) {
			// Fallback to the generic plugin file name.
			$plugin_file_name = 'plugin.php';
		}

		$plugin_file_data = array();
		foreach ( self::$plugin_headers as $header => $required ) {
			$plugin_file_data[ $header ] = $header;
		}

		self::$defined_plugin_headers = get_file_data(
			__DIR__ . "/../{$plugin_file_name}",
			$plugin_file_data
		);
		self::$defined_plugin_headers = array_filter( self::$defined_plugin_headers );
	}

	/**
	 * Test that the readme file has all required headers.
	 *
	 * @dataProvider data_required_readme_headers
	 *
	 * @param string $header Header to test.
	 */
	public function test_required_readme_headers( $header ) {
		$this->assertArrayHasKey( $header, self::$defined_readme_headers, "The readme file header {$header} is missing." );
		$this->assertNotEmpty( self::$defined_readme_headers[ $header ], "The readme file header {$header} is empty." );
	}

	/**
	 * Data provider for test_required_readme_headers.
	 *
	 * @return array[] Data provider.
	 */
	public function data_required_readme_headers() {
		$required_headers = array_filter( self::$readme_headers );
		$headers          = array();
		foreach ( $required_headers as $header => $required ) {
			$headers[ $header ] = array( $header );
		}
		return $headers;
	}

	/**
	 * Test that the plugin file has all required headers.
	 *
	 * @dataProvider data_required_plugin_headers
	 *
	 * @param string $header Header to test.
	 */
	public function test_required_plugin_headers( $header ) {
		$this->assertArrayHasKey( $header, self::$defined_plugin_headers, "The plugin file header {$header} is missing." );
		$this->assertNotEmpty( self::$defined_plugin_headers[ $header ], "The readme file header {$header} is empty." );
	}

	/**
	 * Data provider for test_required_plugin_headers.
	 *
	 * @return array[] Data provider.
	 */
	public function data_required_plugin_headers() {
		$required_headers = array_filter( self::$plugin_headers );
		$headers          = array();
		foreach ( $required_headers as $header => $required ) {
			$headers[ $header ] = array( $header );
		}
		return $headers;
	}

	/**
	 * Test that headers defined in both the readme and plugin file match.
	 *
	 * Note: This test will show as skipped if there are no common headers defined in
	 * both the readme and plugin file. This is fine.
	 *
	 * @dataProvider data_common_headers_match
	 *
	 * @param string $header Header to test.
	 */
	public function test_common_headers_match( $header ) {
		$plugin_header = self::$defined_plugin_headers[ $header ];
		$readme_header = self::$defined_readme_headers[ $header ];

		$this->assertSame( $plugin_header, $readme_header, "The header {$header} does not match between the readme and plugin file." );
	}

	/**
	 * Data provider for test_common_headers_match.
	 *
	 * @return array[] Data provider.
	 */
	public function data_common_headers_match() {
		$common_headers = array_intersect_key(
			self::$defined_readme_headers,
			self::$defined_plugin_headers
		);

		$headers = array();
		foreach ( $common_headers as $header => $value ) {
			$headers[ $header ] = array( $header );
		}
		return $headers;
	}
}
