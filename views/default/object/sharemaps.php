<?php
/**
 * Map renderer.
 *
 * @package ElggShareMaps
 */

$full = elgg_extract('full_view', $vars, FALSE);
$sharemaps = elgg_extract('entity', $vars, FALSE);

if (!$sharemaps) {
	return TRUE;
}

$owner = $sharemaps->getOwnerEntity();
$container = $sharemaps->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = elgg_get_excerpt($sharemaps->description);
$mime = $sharemaps->mimetype;
$base_type = substr($mime, 0, strpos($mime,'/'));

$owner_link = elgg_view('output/url', array(
	'href' => "sharemaps/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$file_icon = elgg_view_entity_icon($sharemaps, 'small');

$date = elgg_view_friendly_time($sharemaps->time_created);

$comments_count = $sharemaps->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $sharemaps->getURL() . '#file-comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'sharemaps',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full && !elgg_in_context('gallery')) {

	$extra = '';
	if (elgg_view_exists("file/specialcontent/$mime")) {
		$extra = elgg_view("file/specialcontent/$mime", $vars);
	} else if (elgg_view_exists("file/specialcontent/$base_type/default")) {
		$extra = elgg_view("file/specialcontent/$base_type/default", $vars);
	}

	$params = array(
		'entity' => $sharemaps,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	$text = elgg_view('output/longtext', array('value' => $sharemaps->description));
	$body = "$text $extra";

	echo elgg_view('object/elements/full', array(
		'entity' => $sharemaps,
		'title' => false,
		'icon' => $file_icon,
		'summary' => $summary,
		'body' => $body,
	));

} elseif (elgg_in_context('gallery')) {
	echo '<div class="file-gallery-item">';
	echo "<h3>" . $sharemaps->title . "</h3>";
	echo elgg_view_entity_icon($sharemaps, 'medium');
	echo "<p class='subtitle'>$owner_link $date</p>";
	echo '</div>';
} else {
	// brief view

	$params = array(
		'entity' => $sharemaps,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($file_icon, $list_body);
}
