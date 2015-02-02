<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

elgg_load_library('elgg:sharemaps');

elgg_push_breadcrumb(elgg_echo('sharemaps'));

// insert google map button
if (sharemaps_allow_gmaps_link()) { 
	elgg_register_title_button('sharemaps','addembed');
}

// draw map button
elgg_register_title_button('sharemaps','drawmap/add');

// upload button
elgg_register_title_button();

$limit = get_input("limit", 10);

$title = elgg_echo('sharemaps:all');

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => array('sharemaps', 'drawmap'),
	'limit' => $limit,
	'full_view' => FALSE
));
if (!$content) {
	$content = elgg_echo('sharemaps:none');
}

$sidebar = sharemaps_get_type_cloud();
$sidebar = elgg_view('sharemaps/sidebar');

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
