<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

$entity = elgg_extract('entity', $vars, elgg_get_page_owner_entity());

echo elgg_view('page/elements/comments_block', [
	'subtypes' => 'sharemaps',
	'container_guid' => $entity ? $entity->guid : null,
]);

echo elgg_view('page/elements/tagcloud_block', [
	'subtypes' => 'sharemaps',
	'container_guid' => $entity ? $entity->guid : null,
]);
