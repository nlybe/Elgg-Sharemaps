<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

use Sharemaps\SharemapsOptions;

elgg_load_external_file('css', 'sharemaps_leaflet_css');
elgg_load_external_file('css', 'sharemaps_leaflet_fullscreen_css');
// elgg_require_css("//unpkg.com/leaflet@{$leafletjs_v}/dist/leaflet.css");
elgg_require_js('sharemaps/leaflet');

$entity = $vars['entity'];    
$map_url = elgg_normalize_url('maps/filepath/'.$entity->guid.'?t='.time());

$map_height = SharemapsOptions::getMapHeight();
echo elgg_format_element('div', ['id' => 'mapid', 'style' => "height: {$map_height}px;"], '');

echo elgg_format_element('div', ['id' => 'murl', 'data-murl' => $map_url, 'style' => 'display:none;'], "");
echo elgg_format_element('div', ['id' => 'mtype', 'data-mtype' => $entity->getMapType(), 'style' => 'display:none;'], "");
echo elgg_format_element('div', ['id' => 'mobjects', 'data-mobjects' => $entity->map_objects, 'style' => 'display:none;'], "");
