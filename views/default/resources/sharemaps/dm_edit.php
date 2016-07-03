<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

elgg_load_library('elgg:sharemaps');

gatekeeper();

$entity_guid = elgg_extract('guid', $vars, '');
$entity_unit = new Drawmap($entity_guid);
if (!$entity_unit) {
	forward();
}
if (!$entity_unit->canEdit()) {
	forward();
}

$title = elgg_echo('sharemaps:edit');

elgg_push_breadcrumb(elgg_echo('sharemaps'), "sharemaps/all");
elgg_push_breadcrumb($entity_unit->title, $entity_unit->getURL());
elgg_push_breadcrumb($title);

elgg_set_page_owner_guid($entity_unit->getContainerGUID());

// get the objects of the map
$map_objects = $entity_unit->getMapObjects();

$form_vars = array('enctype' => 'multipart/form-data'); 
$body_vars = sharemaps_prepare_form_vars_drawmap($entity_unit);
$body_vars["map_objects"] = $map_objects;
$content = elgg_view_form('sharemaps/drawmap', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
