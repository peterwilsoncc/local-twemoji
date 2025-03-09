#!/usr/bin/env bash

# Show the command we are running
# set -x

# Get the path to this file.
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Get the current version from the package-lock.json file
CURRENT_VERSION=$(jq -r '.packages["node_modules/@twemoji/api"].version' "$SCRIPT_DIR/../package-lock.json")

echo "Current version is $CURRENT_VERSION"

# Get the latest release for the twemoji project use the GitHub CLI
TWEMOJI_LATEST_RELEASE_TAG=$(gh release view --json tagName --repo jdecked/twemoji | jq -r '.tagName')

# Remove the leading "v" from the tag name
TWEMOJI_LATEST_RELEASE=${TWEMOJI_LATEST_RELEASE_TAG#"v"}

# Do nothing if the versions are the same.
if [ "$CURRENT_VERSION" == "$TWEMOJI_LATEST_RELEASE" ]; then
	echo "Versions are the same, nothing to do."
	exit;
fi

# Delete the existing ../images/emoji/ directory
rm -rf "$SCRIPT_DIR/../images/emoji/"
mkdir -p "$SCRIPT_DIR/../images/emoji/"


echo "Updating to version $TWEMOJI_LATEST_RELEASE"

# Update to the latest version in the NPM config.
npm uninstall @twemoji/api --save-dev
npm install @twemoji/api@$TWEMOJI_LATEST_RELEASE --save-dev --save-exact

# Download the SVG images from the twemoji project
gh release download $TWEMOJI_LATEST_RELEASE_TAG --repo jdecked/twemoji --archive zip --output "$SCRIPT_DIR/../images/emoji/twemoji-$TWEMOJI_LATEST_RELEASE_TAG.zip"

# Unzip the downloaded file
unzip "$SCRIPT_DIR/../images/emoji/twemoji-$TWEMOJI_LATEST_RELEASE_TAG.zip" -d "$SCRIPT_DIR/../images/emoji/"

# Remove the downloaded zip file
rm "$SCRIPT_DIR/../images/emoji/twemoji-$TWEMOJI_LATEST_RELEASE_TAG.zip"

# Move the SVG images to the correct directory
mv "$SCRIPT_DIR/../images/emoji/twemoji-$TWEMOJI_LATEST_RELEASE/assets/svg" "$SCRIPT_DIR/../images/emoji/"

# Move the PNG images to the correct directory
mv "$SCRIPT_DIR/../images/emoji/twemoji-$TWEMOJI_LATEST_RELEASE/assets/72x72" "$SCRIPT_DIR/../images/emoji/"

# Remove the downloaded directory
rm -rf "$SCRIPT_DIR/../images/emoji/twemoji-$TWEMOJI_LATEST_RELEASE"

# Get a list of all the SVG files.
SVG_FILES=$(find "$SCRIPT_DIR/../images/emoji/svg" -type f -name "*.svg")


# Do the rest via the PHP script.
php "$SCRIPT_DIR/convert-to-entities.php" $SVG_FILES


# echo $SVG_FILES;
exit;
