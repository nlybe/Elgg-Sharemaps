<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => ElggMap::SUBTYPE,
	'distinct' => false,
	'pagination' => false,
]);
