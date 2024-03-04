<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

use Sharemaps\SharemapsOptions;

$group_guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($group_guid, 'group');

$group = get_entity($group_guid);

// register post buttons
SharemapsOptions::getPostButtons();

elgg_push_collection_breadcrumbs('object', 'sharemaps', $group);

$title = elgg_echo('collection:object:sharemaps');

$content = elgg_view('sharemaps/listing/group', [
	'entity' => $group,
]);

$layout = elgg_view_layout('default', [
	'title' => $title,
	'content' => $content,
	'filter_id' => 'sharemaps/group',
	'filter_value' => 'all',
]);

echo elgg_view_page($title, $layout);
