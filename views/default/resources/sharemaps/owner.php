<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

elgg_load_library('elgg:sharemaps');

// access check for closed groups
group_gatekeeper();

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('sharemaps/all');
}

elgg_push_breadcrumb(elgg_echo('sharemaps'), "sharemaps/all");
elgg_push_breadcrumb($owner->name);

// register post buttons, depending on settings
$sm_map_types = elgg_get_config('sm_map_types');
foreach ($sm_map_types as $name => $type_info) {
    if (sharemaps_is_type_active($name)) {
        elgg_register_title_button('sharemaps', $type_info['button']);
    }
}

$params = array();

if ($owner->guid == elgg_get_logged_in_user_guid()) {
	// user looking at own maps
	$params['filter_context'] = 'mine';
} else if (elgg_instanceof($owner, 'user')) {
	// someone else's maps
	// do not show select a tab when viewing someone else's posts
	$params['filter_context'] = 'none';
} else {
	// group files
	$params['filter'] = '';
}

$title = elgg_echo("sharemaps:user", array($owner->name));

// List maps
$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => array('sharemaps', 'drawmap'),
	'container_guid' => $owner->guid,
	'limit' => 10,
	'full_view' => FALSE,
));
if (!$content) {
	$content = elgg_echo("sharemaps:none");
}

$sidebar = sharemaps_get_type_cloud(elgg_get_page_owner_guid());
$sidebar = elgg_view('sharemaps/sidebar');

$params['content'] = $content;
$params['title'] = $title;
$params['sidebar'] = $sidebar;

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
