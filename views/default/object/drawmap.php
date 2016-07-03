<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

$full = elgg_extract('full_view', $vars, FALSE);

if ($full && !elgg_in_context('gallery')) {
    elgg_load_css('sharemaps_drawonmaps_css');
}

$entity = elgg_extract('entity', $vars, FALSE);

if (!$entity) {
    return TRUE;
}

$owner = $entity->getOwnerEntity();
$container = $entity->getContainerEntity();
$excerpt = elgg_get_excerpt($entity->description);

$owner_link = elgg_view('output/url', array(
    'href' => "sharemaps/owner/$owner->username",
    'text' => $owner->name,
    'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$owner_icon = elgg_view_entity_icon($owner, 'small');

$date = elgg_view_friendly_time($entity->time_created);

$comments_count = $entity->countComments();
//only display if there are commments
if ($comments_count != 0) {
    $text = elgg_echo("comments") . " ($comments_count)";
    $comments_link = elgg_view('output/url', array(
        'href' => $entity->getURL() . '#comments',
        'text' => $text,
        'is_trusted' => true,
    ));
} 
else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
    'entity' => $vars['entity'],
    'handler' => 'sharemaps/drawmap',
    'sort_by' => 'priority',
    'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link";

//Read map width and height from settings
$vars['map_width'] = sharemaps_get_map_width();
$vars['map_height'] = sharemaps_get_map_height();

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full && !elgg_in_context('gallery')) {

    $params = array(
        'entity' => $entity,
        'metadata' => $metadata,
        'subtitle' => $subtitle,
    );
    $params = $params + $vars;
    $summary = elgg_view('object/elements/summary', $params);

    if (sharemaps_display_map_before_description()) {
        $text = elgg_view('sharemaps/map_draw_box', $vars);
        $text .= elgg_view('output/longtext', array('value' => $entity->description));
    }
    else {
        $text = elgg_view('output/longtext', array('value' => $entity->description));
    $text .= elgg_view('sharemaps/map_draw_box', $vars);
    }
    

    $body = "$text $extra";

    echo elgg_view('object/elements/full', array(
        'entity' => $entity,
        'title' => false,
        'icon' => $owner_icon,
        'summary' => $summary,
        'body' => $body,
    ));

} 
elseif (elgg_in_context('gallery')) {
    echo '<div class="file-gallery-item">';
    echo "<h3>" . $entity->title . "</h3>";
    echo elgg_view_entity_icon($entity, 'medium');
    echo "<p class='subtitle'>$owner_link $date</p>";
    echo '</div>';
} 
else {
    // brief view

    $params = array(
        'entity' => $entity,
        'metadata' => $metadata,
        'subtitle' => $subtitle,
        'content' => $excerpt,
    );
    $params = $params + $vars;
    $list_body = elgg_view('object/elements/summary', $params);

    echo elgg_view_image_block($owner_icon, $list_body);
}
