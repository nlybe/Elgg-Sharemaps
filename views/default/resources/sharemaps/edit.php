<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

use Sharemaps\SharemapsOptions;

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', ElggMap::SUBTYPE);

$entity = get_entity($guid);

if (!$entity->canEdit()) {
	throw new \Elgg\EntityPermissionsException(elgg_echo('sharemaps:unknown_map'));
}

$title = elgg_echo('edit:object:map');

elgg_push_breadcrumb(elgg_echo('sharemaps'), 'maps');
elgg_push_entity_breadcrumbs($entity, true);

$vars = SharemapsOptions::sharemaps_prepare_form_vars($entity);
$content = elgg_view_form('sharemaps/edit', [
	'enctype' => 'multipart/form-data',
	'action' => 'action/sharemaps/save',
], $vars); 

$body = elgg_view_layout('default', [
	'filter_id' => 'sharemaps/edit',
	'content' => $content,
	'title' => $title,
]);

echo elgg_view_page($title, $body);
