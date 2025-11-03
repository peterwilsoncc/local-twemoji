Bumps twemoji files to %%LATEST_VERSION%%.

Fixes #%%ISSUE_NUMBER%%

Bot steps:

* [x] Update `package.json` and `package-lock.json` with new Twemoji version.
* [x] Update images.
* [x] Update `TWEMOJI_VERSION` constant in `namespace.php` file.

Human steps:

* Apply a minor version bump to the plugin, ie 0.1.0.
   * [ ] Run `npm --no-git-tag-version version minor`
   * [ ] Version number in PHP header
   * [ ] Stable version in readme.txt header
   * [ ] `PLUGIN_VERSION` constant in main namespace file.
   * [ ] Update changelog file.
* [ ] Increase WP minimum required version if applicable.
