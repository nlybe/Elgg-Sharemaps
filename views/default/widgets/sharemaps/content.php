<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display ?: 4;

$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => ElggMap::SUBTYPE,
	'container_guid' => $widget->owner_guid,
	'limit' => $num_display,
	'pagination' => false,
	'distinct' => false,
]);

if (empty($content)) {
	echo elgg_echo('sharemaps:none');
	return;
}

echo $content;

$owner = $widget->getOwnerEntity();
if ($owner instanceof ElggGroup) {
	$url = elgg_generate_url('collection:object:sharemaps:group', ['guid' => $owner->guid]);
} else {
	$url = elgg_generate_url('collection:object:sharemaps:owner', ['username' => $owner->username]);
}

$more_link = elgg_view('output/url', [
	'href' => $url,
	'text' => elgg_echo('more'),
	'is_trusted' => true,
]);
echo elgg_format_element('div', ['class' => 'elgg-widget-more'], $more_link);
