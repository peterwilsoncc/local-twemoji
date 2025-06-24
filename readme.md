# Local Twemoji

Self hosted Twemoji images

[![PHP Unit Tests](https://github.com/peterwilsoncc/local-twemoji/actions/workflows/phpunit.yaml/badge.svg)](https://github.com/peterwilsoncc/local-twemoji/actions/workflows/phpunit.yaml) [![Coding Standards](https://github.com/peterwilsoncc/local-twemoji/actions/workflows/coding-standards.yaml/badge.svg)](https://github.com/peterwilsoncc/local-twemoji/actions/workflows/coding-standards.yaml)

## Description

Local Twemoji is a WordPress plugin to serve fallback emoji images from your own site URL rather than the WordPress.org CDN.

The purpose of this plugin is to aid sites served over a CDN as browsers now cache requests on a per site basis rather than globally.

The effect of this is that the WordPress.org CDN's splat image is treated as two different images if downloaded from site-one.example and site-two.example. You can read more about this in the Chrome post on [cache partitioning](https://developer.chrome.com/blog/http-cache-partitioning).

For sites served over a CDN, downloading the image from your own URL will be quicker as it reduces the number of servers the visitor's browser needs to connect to.

## Installation

Local Twemoji can be installed via the following methods.

*Composer*

```
composer require peterwilsoncc/local-twemoji
```

*Downloads*

* Via WordPress.org
* [Via GitHub](https://github.com/peterwilsoncc/local-twemoji/releases/latest)
