<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

use Sharemaps\SharemapsOptions;

elgg_load_css('sharemaps_leaflet_css');
elgg_load_css('sharemaps_leaflet_draw_css');
elgg_load_css('sm_leaflet_autocomplete_css');

elgg_require_js('sharemaps/leaflet_edit'); 

$entity = $vars['entity']; 

$file_input_options = [
    'id' => 'file_upload',
    '#type' => 'file',
    'name' => 'upload',
    '#help' => elgg_echo('sharemaps:add:file:help'),
];
if (!$entity instanceof ElggMap) {
    $file_input_options["disabled"] = true;
    $file_input_options["#help"] = elgg_echo('sharemaps:add:file:help:noentity');
}
echo elgg_view_field($file_input_options);

$map_height = SharemapsOptions::getMapHeight();
echo elgg_format_element('div', ['id' => 'mapid', 'style' => "height: {$map_height}px;"], '');

   
if ($entity instanceof ElggMap) {
    $map_url = elgg_normalize_url('maps/filepath/'.$entity->guid.'?t='.time());
    $map_objects = $entity->map_objects;

    echo elgg_format_element('div', ['id' => 'murl', 'data-murl' => $map_url, 'style' => 'display:none;'], "");
    echo elgg_format_element('div', ['id' => 'mtype', 'data-mtype' => $entity->getMapType(), 'style' => 'display:none;'], "");
}

echo elgg_view_field([
    '#type' => 'hidden',
    'id' => 'map_objects',
    'name' => 'map_objects',
    'value' => $map_objects?$map_objects:'',
]);
