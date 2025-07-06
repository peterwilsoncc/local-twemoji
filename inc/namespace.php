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

	add_filter( 'plugin_row_meta', __NAMESPACE__ . '\\add_plugin_action_links', 10, 3 );
	add_action( 'admin_menu', __NAMESPACE__ . '\\register_admin_menu' );
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

/**
 * Register the admin menu for the credits page.
 */
function register_admin_menu() {
	add_submenu_page(
		'admin.php',
		esc_html__( 'Local Twemoji Credits', 'local-twemoji' ),
		esc_html__( 'Local Twemoji Credits', 'local-twemoji' ),
		'manage_options',
		'local-twemoji-credits',
		__NAMESPACE__ . '\\print_credits_page'
	);
}

/**
 * Add action links to the plugin.
 *
 * @param array  $links       The existing action links.
 * @param string $file        The plugin file.
 * @param array  $plugin_data The plugin data.
 * @return array The modified action links.
 */
function add_plugin_action_links( $links, $file, $plugin_data ) {
	/*
	 * Only add the credits link for Local Twemoji.
	 *
	 * - str_ends_with: accounts for mu-plugins
	 * - Text Domain: unlikely to change
	 */
	if (
		! str_ends_with( $file, '/local-twemoji.php' )
		|| 'local-twemoji' !== $plugin_data['TextDomain']
	) {
		return $links;
	}

	$links['credits'] = sprintf(
		'<a href="%s">%s</a>',
		esc_url( admin_url( 'admin.php?page=local-twemoji-credits' ) ),
		esc_html__( 'Credits', 'local-twemoji' )
	);

	return $links;
}

/**
 * Print the credits page for the plugin.
 */
function print_credits_page() {
	?>
	<div class="wrap local-twemoji-credits">
	<h2><?php esc_html_e( 'Twemoji Credits', 'local-twemoji' ); ?></h2>
	<p>
		<?php
		esc_html_e( 'The Local Twemoji plugin uses the following resources:', 'local-twemoji' );
		?>
	</p>
	<ul style="list-style: disc inside;">
		<li>
			<?php
			printf(
				// translators: %1$s opening link tag to Twemoji; %2$s closing link tag.
				esc_html__( 'Images provided by the %1$sTwemoji project%2$s CC-BY 4.0 © Twitter Inc and contributors', 'local-twemoji' ),
				'<a href="https://github.com/jdecked/twemoji?tab=readme-ov-file">',
				'</a>'
			);
			?>
		</li>
		<li>
			<?php
			printf(
				// translators: %1$s opening link tag to Peter Wilson; %2$s closing link tag.
				esc_html__( 'Local Twemoji plugin by %1$sPeter Wilson%2$s MIT © Peter Wilson', 'local-twemoji' ),
				'<a href="https://peterwilson.cc">',
				'</a>'
			);
			?>
		</li>
		<li>
			<?php
			printf(
				// translators: %1$s opening link tag to WordPress credits page; %2$s closing link tag.
				esc_html__( 'See the WordPress %1$scredits page%2$s for further acknowledgements', 'local-twemoji' ),
				'<a href="' . esc_url( admin_url( 'credits.php' ) ) . '">',
				'</a>'
			);
			?>
		</li>
	</ul>

	<h3><?php esc_html_e( 'Contributing to Local Twemoji', 'local-twemoji' ); ?></h3>

	<p>
		<?php
		printf(
			// translators: %1$s opening link tag to GitHub repository; %2$s closing link tag; %3$s opening link tag to support forums; %4$s closing link tag.
			esc_html__( 'Please visit the %1$sLocal Twemoji GitHub repository%2$s to contribute, suggest an enhancement or report a bug. You can request assistance in the %3$splugin\'s support forums%4$s.', 'local-twemoji' ),
			'<a href="https://github.com/peterwilsoncc/local-twemoji/">',
			'</a>',
			'<a href="https://wordpress.org/support/plugin/local-twemoji/">',
			'</a>'
		);
		?>
	</p>

	<p>
		<?php
		printf(
			// translators: %1$s opening link tag to the plugin's review page; %2$s closing link tag.
			esc_html__( 'If this plugin makes you 😁, please post a %1$sreview on WordPress.org%2$s.', 'local-twemoji' ),
			'<a href="https://wordpress.org/support/plugin/local-twemoji/reviews/#new-post">',
			'</a>'
		);
		?>
	</p>

	</div>

	<?php
}
