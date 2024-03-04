<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggEntity) {
	return;
}

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => ElggMap::SUBTYPE,
	'container_guids' => $entity->guid,
	'no_results' => elgg_echo('sharemaps:none'),
]);
