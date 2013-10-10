<?php
/**
 * Elgg sharemaps all maps
 *
 * @package ElggShareMaps
 */

elgg_push_breadcrumb(elgg_echo('sharemaps'));

// insert google map button
/*
elgg_register_menu_item('title', array(
	'name' => 'addembed',
	'text' => elgg_echo('sharemaps:embed'),
	'href' => "sharemaps/addembed/35",
	'link_class' => 'elgg-button elgg-button-action',
));*/

// insert google map button
elgg_register_title_button('sharemaps','addembed');
// upload button
elgg_register_title_button();


$limit = get_input("limit", 10);

$title = elgg_echo('sharemaps:all');

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => 'sharemaps',
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
