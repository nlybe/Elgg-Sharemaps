<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

$group_guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($group_guid, 'group');

elgg_group_tool_gatekeeper('sharemaps', $group_guid);

$group = get_entity($group_guid);

elgg_register_title_button('sharemaps', 'add', 'object', 'sharemaps');

elgg_push_collection_breadcrumbs('object', 'sharemaps', $group);

$title = elgg_echo('collection:object:sharemaps');
$content = elgg_view('sharemaps/listing/group', [
	'entity' => $group,
]);

echo elgg_view_page(elgg_echo('collection:object:sharemaps'), [
	'content' => $content,
	'filter_id' => 'sharemaps/group',
	'filter_value' => 'all',
]);