<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => ElggMap::SUBTYPE,
	'no_results' => elgg_echo('sharemaps:none'),
	'distinct' => false,
]);
