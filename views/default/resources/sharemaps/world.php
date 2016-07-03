<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

elgg_load_library('elgg:sharemaps');

elgg_push_breadcrumb(elgg_echo('sharemaps'));

// register post buttons, depending on settings
$sm_map_types = elgg_get_config('sm_map_types');
foreach ($sm_map_types as $name => $type_info) {
    if (sharemaps_is_type_active($name)) {
        elgg_register_title_button('sharemaps', $type_info['button']);
    }
}

$limit = get_input("limit", 10);

$title = elgg_echo('sharemaps:all');

$content = elgg_list_entities(array(
    'types' => 'object',
    'subtypes' => array('sharemaps', 'drawmap'),
    'limit' => $limit,
    'full_view' => FALSE
));
if (!$content) {
    $content = elgg_echo('sharemaps:none');
}

$sidebar = sharemaps_get_type_cloud();
$sidebar = elgg_view('sharemaps/sidebar');

$body = elgg_view_layout('content', array(
    'filter_context' => 'all',
    'content' => $content,
    'title' => $title,
    'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
