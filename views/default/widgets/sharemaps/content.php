<?php
/**
 * Elgg map widget view
 *
 * @package ElggShareMaps
 */


$num = $vars['entity']->num_display;

$options = array(
	'type' => 'object',
	'subtypes' => array('sharemaps', 'drawmap'),
	'container_guid' => $vars['entity']->owner_guid,
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_list_entities($options);

echo $content;

if ($content) {
	$url = "sharemaps/owner/" . elgg_get_page_owner_entity()->username;
	$more_link = elgg_view('output/url', array(
		'href' => $url,
		'text' => elgg_echo('sharemaps:more'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('sharemaps:none');
}
