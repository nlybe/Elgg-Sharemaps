<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

use Sharemaps\SharemapsOptions;

$username = elgg_extract('username', $vars);

$user = get_user_by_username($username);
if (!$user) {
	throw new \Elgg\EntityNotFoundException();
}

elgg_push_breadcrumb(elgg_echo('sharemaps'));
elgg_push_collection_breadcrumbs('object', 'sharemaps', $user, true);

// register post buttons
SharemapsOptions::getPostButtons();

$title = elgg_echo('collection:object:sharemaps:friends');

$content = elgg_view('sharemaps/listing/friends', [
	'entity' => $user,
]);

$body = elgg_view_layout('default', [
	'filter_value' => $user->guid == elgg_get_logged_in_user_guid() ? 'friends' : 'none',
	'content' => $content,
	'title' => $title,
]);

echo elgg_view_page($title, $body);
