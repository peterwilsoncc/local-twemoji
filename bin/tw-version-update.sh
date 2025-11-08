#!/usr/bin/env bash

# Show the command we are running
# set -x

# Get the path to this file.
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Get the current version from the package-lock.json file
CURRENT_VERSION=$(jq -r '.packages["node_modules/@twemoji/api"].version' "$SCRIPT_DIR/../package-lock.json")

echo "Current version is $CURRENT_VERSION"

# Get the latest release for the twemoji project from NPM.
TWEMOJI_LATEST_RELEASE=$(curl -s https://registry.npmjs.org/@twemoji/api/latest | jq -r '.version')

# Do nothing if the versions are the same.
if [ "$CURRENT_VERSION" == "$TWEMOJI_LATEST_RELEASE" ]; then
	echo "Versions are the same, nothing to do."
	exit;
fi

# Delete the existing ../images/emoji/ directory
rm -rf "$SCRIPT_DIR/../images/emoji/"
mkdir -p "$SCRIPT_DIR/../images/emoji/"


echo "Updating to version $TWEMOJI_LATEST_RELEASE"

# Download the images from the twemoji project
curl -L -o "$SCRIPT_DIR/../images/emoji/twemoji-$TWEMOJI_LATEST_RELEASE.zip" "https://github-proxy.com/proxy/?repo=jdecked/twemoji&branch=gh-pages&directory=v/$TWEMOJI_LATEST_RELEASE"

# Unzip the downloaded file
unzip "$SCRIPT_DIR/../images/emoji/twemoji-$TWEMOJI_LATEST_RELEASE.zip" -d "$SCRIPT_DIR/../images/emoji/"

# Remove the downloaded zip file
rm "$SCRIPT_DIR/../images/emoji/twemoji-$TWEMOJI_LATEST_RELEASE.zip"

# Move the SVG images to the correct directory
mv "$SCRIPT_DIR/../images/emoji/v/$TWEMOJI_LATEST_RELEASE/svg" "$SCRIPT_DIR/../images/emoji/"

# Move the PNG images to the correct directory.
mv "$SCRIPT_DIR/../images/emoji/v/$TWEMOJI_LATEST_RELEASE/72x72" "$SCRIPT_DIR/../images/emoji/"

# Remove the unzipped directory
rm -rf "$SCRIPT_DIR/../images/emoji/v"

# Commit the image updates to git
git add "$SCRIPT_DIR/../images/emoji/svg"
git add "$SCRIPT_DIR/../images/emoji/72x72"
git commit -am "Update Twemoji images to version $TWEMOJI_LATEST_RELEASE"

# Remove the downloaded directory
rm -rf "$SCRIPT_DIR/../images/emoji/twemoji-$TWEMOJI_LATEST_RELEASE"

# Update to the latest version in the NPM config.
npm uninstall @twemoji/api --save-dev
npm install @twemoji/api@$TWEMOJI_LATEST_RELEASE --save-dev --save-exact

# Update the version number in the namespace file.
echo "Updating version in namespace file"
NAMESPACE_FILE="$SCRIPT_DIR/../inc/namespace.php"
if [ -f "$NAMESPACE_FILE" ]; then
	sed -i.bak "s/const TWEMOJI_VERSION = '.*';/const TWEMOJI_VERSION = '$TWEMOJI_LATEST_RELEASE';/" "$NAMESPACE_FILE"
	rm "$NAMESPACE_FILE.bak"
else
	echo "Warning: namespace.php file not found."
fi

git commit -am "Update Twemoji version number references to $TWEMOJI_LATEST_RELEASE";
