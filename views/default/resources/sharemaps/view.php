<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', ElggMap::SUBTYPE);

$entity = get_entity($guid);

elgg_push_breadcrumb(elgg_echo('sharemaps'), 'maps');
elgg_push_entity_breadcrumbs($entity, true);

$title = $entity->getDisplayName();

$content = elgg_view_entity($entity, [
	'full_view' => true,
	'show_responses' => true,
]);

if (elgg_is_logged_in()) {
	elgg_register_menu_item('title', [
		'name' => 'download',
		'text' => elgg_echo('download'),
		'href' => $entity->getDownloadURL(),
		'icon' => 'download',
		'link_class' => 'elgg-button elgg-button-action',
	]);
}

$body = elgg_view_layout('default', [
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'entity' => $entity,
	'sidebar' => elgg_view('object/sharemaps/elements/sidebar', [
		'entity' => $entity,
	]),
]);

echo elgg_view_page($title, $body, 'default', [
	'entity' => $entity,
]);
