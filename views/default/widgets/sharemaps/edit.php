<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

$widget = elgg_extract('entity', $vars);

echo elgg_view('object/widget/edit/num_display', [
	'entity' => $widget,
	'label' => elgg_echo('sharemaps:numbertodisplay'),
	'default' => 4,
]);
