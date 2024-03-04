<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

use Sharemaps\SharemapsOptions;

$entity = elgg_extract('entity', $vars, false);
if (!$entity instanceof ElggMap) {
	return;
}

$owner = $entity->getOwnerEntity();

if (elgg_extract('full_view', $vars)) {
	if ($entity->description) {
		$description = elgg_format_element('div', ['class' => 'map_content elgg-content mts'], 
			elgg_view('output/longtext', [
				'value' => $entity->description,
				'class' => 'pbl',
			])
		); 
	}
	$mapbox = elgg_view('output/mapdraw', ['entity' => $entity]);
	
	if (SharemapsOptions::getParams('map_location') == SharemapsOptions::MAP_LOCATION_AFTER) {
		$body .= $description.$mapbox;
	}
	else {
		$body .= $mapbox.$description;
	}	
	
	$params = [
		'icon' => true,
		'show_summary' => true,
		'body' => $body,
		'show_responses' => elgg_extract('show_responses', $vars, false),
		'show_navigation' => true,
	];
	$params = $params + $vars;

	echo elgg_view('object/elements/full', $params);
	return;
}

// brief view
$excerpt = elgg_get_excerpt($entity->description);
if ($excerpt) {
	$excerpt = " - $excerpt";
}

$content = "{$excerpt}";

$params = [
	'content' => $content,
	'icon' => true,
];
$params = $params + $vars;
echo elgg_view('object/elements/summary', $params);
