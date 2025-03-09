<?php

namespace PWCC\LocalTwemoji\Entities;

/**
 * Returns arrays of emoji data.
 *
 * These arrays are automatically built from the regex in twemoji.js - if they need to be updated,
 * you should update the regex there, then run the `npm run grunt precommit:emoji` job.
 *
 * @since 4.9.0
 * @access private
 *
 * @param string $type Optional. Which array type to return. Accepts 'partials' or 'entities', default 'entities'.
 * @return array An array to match all emoji that WordPress recognises.
 */
function _wp_emoji_list( $type = 'entities' ) {
	// Do not remove the START/END comments - they're used to find where to insert the arrays.

	// START: emoji arrays.
	$entities = array();
	$partials = array();
	// END: emoji arrays.

	if ( 'entities' === $type ) {
		return $entities;
	}

	return $partials;
}
