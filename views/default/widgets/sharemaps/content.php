<?php
/**
 * Elgg map widget view
 *
 * @package ElggShareMaps
 */

elgg_load_library('elgg:sharemaps');
$num = $vars['entity']->num_display;
$owner = get_entity($vars['entity']->owner_guid);

$options = array(
	'type' => 'object',
	'subtypes' => array('sharemaps', 'drawmap'),
	'container_guid' => $vars['entity']->owner_guid,
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_list_entities($options);

if (elgg_instanceof($owner, 'group')) {
    $url = elgg_normalize_url('sharemaps/group/'.$owner->getGUID().'/all');
    $link_text = elgg_echo("mm_lectures:widget:viewall:group");
}
else {
    $url = "sharemaps/owner/" . elgg_get_page_owner_entity()->username;
    $link_text = elgg_echo("mm_lectures:widget:viewall");
}

if ($content) {
    echo $content;    
    
    $more_link = elgg_view('output/url', array(
        'href' => $url,
        'text' => elgg_echo('sharemaps:more'),
        'is_trusted' => true,
    ));
    echo elgg_format_element('span', ['class' => 'elgg-widget-more'], $more_link);
    
} 
else {
    echo elgg_echo('sharemaps:none');
}
