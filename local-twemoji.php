<?php
/**
 * Local Twemoji
 *
 * @package           LocalTwemoji
 * @author            Peter Wilson
 * @copyright         2025 Peter Wilson
 * @license           MIT
 *
 * @wordpress-plugin
 * Plugin Name: Local Twemoji
 * Description: Serve Twemoji from your own server instead of a CDN.
 * Version: 1.3.1
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Peter Wilson
 * Author URI: https://peterwilson.cc
 * License: MIT
 * License URI: https://github.com/peterwilsoncc/local-twemoji/?tab=MIT-1-ov-file
 * Text Domain: local-twemoji
 */

namespace PWCC\LocalTwemoji;

require_once __DIR__ . '/inc/namespace.php';

bootstrap();
