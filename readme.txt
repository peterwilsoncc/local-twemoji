=== Local Twemoji ===
Contributors: peterwilsoncc
Tags: emoji, twemoji, performance
Tested up to: 6.8
Stable tag: 1.0.0
License: MIT
License URI: https://github.com/peterwilsoncc/local-twemoji/?tab=MIT-1-ov-file

Self hosted Twemoji images

== Description ==

Local Twemoji is a WordPress plugin to serve fallback emoji images from your own site URL rather than the WordPress.org CDN.

The purpose of this plugin is to aid sites served over a CDN as browsers now cache requests on a per site basis rather than globally.

The effect of this is that the WordPress.org CDN's splat image is treated as two different images if downloaded from site-one.example and site-two.example. You can read more about this in the Chrome post on [cache partitioning](https://developer.chrome.com/blog/http-cache-partitioning).

For sites served over a CDN, downloading the image from your own URL will be quicker as it reduces the number of servers the visitor's browser needs to connect to.

== Frequently Asked Questions ==

= Where is the settings page? =

There is no settings page for this plugin, simply activate the plugin and it will work as intended.

= How is this plugin licensed? =

The plugin code is licensed under the [MIT License](https://github.com/peterwilsoncc/local-twemoji/?tab=MIT-1-ov-file).

The Emoji SVG and PNG assets are licensed under the [CC-BY 4.0 License](https://github.com/jdecked/twemoji?tab=CC-BY-4.0-2-ov-file). Copyright Twitter Inc. and other [contributors](https://github.com/jdecked/twemoji/graphs/contributors).

== Changelog ==

= 1.0.0 =

Initial release.

= Full changelogs =

View the [releases](https://github.com/peterwilsoncc/local-twemoji/releases) on GitHub for the full change logs. This log will contain only the most recent releases.
