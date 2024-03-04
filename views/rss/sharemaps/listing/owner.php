<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggUser) {
	return;
}

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => ElggMap::SUBTYPE,
	'owner_guids' => $entity->guid,
	'pagination' => false,
]);
