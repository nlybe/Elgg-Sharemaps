<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

elgg_load_library('elgg:sharemaps');

$owner = elgg_get_page_owner_entity();
if (!$owner) {
    forward('sharemaps/all');
}

elgg_push_breadcrumb(elgg_echo('sharemaps'), "sharemaps/all");
elgg_push_breadcrumb($owner->name, "sharemaps/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

// register post buttons, depending on settings
$sm_map_types = elgg_get_config('sm_map_types');
foreach ($sm_map_types as $name => $type_info) {
    if (sharemaps_is_type_active($name)) {
        elgg_register_title_button('sharemaps', $type_info['button']);
    }
}

$title = elgg_echo("sharemaps:friends");

$content = elgg_list_entities_from_relationship(array(
	'type' => 'object',
	'subtype' => array('sharemaps', 'drawmap'),
	'full_view' => false,
	'limit' => 10,
	'relationship' => 'friend',
	'relationship_guid' => $owner->guid,
	'relationship_join_on' => 'container_guid',
));

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
