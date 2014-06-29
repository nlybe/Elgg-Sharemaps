<?php
/**
 * Elgg sharemaps friends maps
 *
 * @package ElggShareMaps
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('sharemaps/all');
}

elgg_push_breadcrumb(elgg_echo('sharemaps'), "sharemaps/all");
elgg_push_breadcrumb($owner->name, "sharemaps/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

// insert google map button
elgg_register_title_button('sharemaps','addembed');
// upload button
elgg_register_title_button();

$title = elgg_echo("sharemaps:friends");

// offset is grabbed in list_user_friends_objects
$content = list_user_friends_objects($owner->guid, 'sharemaps', 10, false);
if (!$content) {
	$content = elgg_echo("sharemaps:none");
}

$sidebar = sharemaps_get_type_cloud($owner->guid, true);

$body = elgg_view_layout('content', array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
