<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

use Sharemaps\SharemapsOptions;

elgg_require_js("sharemaps/admin");
	
$plugin = elgg_get_plugin_from_id(SharemapsOptions::PLUGIN_ID);

$potential_yes_no = array(
    SharemapsOptions::SM_YES => elgg_echo('sharemaps:settings:yes'),
    SharemapsOptions::SM_NO => elgg_echo('sharemaps:settings:no'),
);

$potential_before_after = array(
    SharemapsOptions::MAP_LOCATION_BEFORE => elgg_echo('sharemaps:settings:before'),
    SharemapsOptions::MAP_LOCATION_AFTER => elgg_echo('sharemaps:settings:after'),
);

// // default map location coords
// echo elgg_format_element('div', [], elgg_view_input('text', array(
//     'name' => 'params[default_coords]',
//     'value' => $plugin->default_coords,
//     'label' => elgg_echo('sharemaps:settings:default_coords'),
//     'help' => elgg_echo('sharemaps:settings:default_coords:help'),
// )));

// LeafletJS version
echo elgg_view_field([
    '#type' => 'text',
    'name' => 'params[leafletjs_version]',
    'value' => $plugin->leafletjs_version,
    '#label' => elgg_echo('sharemaps:settings:leafletjs_version'),
    '#help' => elgg_echo('sharemaps:settings:leafletjs_version:help'),
    'style' => 'width: 200px;',
]);

// LeafletJS Draw version
echo elgg_view_field([
    '#type' => 'text',
    'name' => 'params[leaflet_draw_version]',
    'value' => $plugin->leaflet_draw_version,
    '#label' => elgg_echo('sharemaps:settings:leaflet_draw_version'),
    '#help' => elgg_echo('sharemaps:settings:leaflet_draw_version:help'),
    'style' => 'width: 200px;',
]);

// Map height
echo elgg_view_field([
    '#type' => 'text',
    'name' => 'params[map_height]',
    'value' => $plugin->map_height,
    '#label' => elgg_echo('sharemaps:settings:map_height'),
    '#help' => elgg_echo('sharemaps:settings:map_height:help'),
    'style' => 'width: 200px;',
]);

// Google API
echo elgg_view_field([
    '#type' => 'checkbox',
    'id' => 'google_maps_api',
    'name' => 'params[google_maps_api]',
    'default' => 'no',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->google_maps_api === 'yes'),  
    '#label' => elgg_echo('sharemaps:settings:google_maps_api'),
    '#help' => elgg_echo('sharemaps:settings:google_maps_api:help'),
]);

// Google API Key
echo elgg_view_field([
    '#type' => 'text',
    'id' => 'google_maps_api_key',
    'name' => 'params[google_maps_api_key]',
    'value' => $plugin->google_maps_api_key,
    '#label' => elgg_echo('sharemaps:settings:google_maps_api_key'),
    '#help' => elgg_echo('sharemaps:settings:google_maps_api_key:help'),
]);

// select where to load map regarding description
echo elgg_view_field([
    '#type' => 'dropdown',
    'name' => 'params[map_location]',
    'value' => $plugin->map_location,
    'options_values' => $potential_before_after,
    '#label' => elgg_echo('sharemaps:settings:map_location'),
    '#help' => elgg_echo('sharemaps:settings:map_location:help'),
]);

// Enable leafletjs edit toolbox
echo elgg_view_field([
    '#type' => 'checkbox',
    'id' => 'leafletjs_toolbox_enabled',
    'name' => 'params[leafletjs_toolbox_enabled]',
    'default' => 'no',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->leafletjs_toolbox_enabled === 'yes'),  
    '#label' => elgg_echo('sharemaps:settings:leafletjs_toolbox_enabled'),
    '#help' => elgg_echo('sharemaps:settings:leafletjs_toolbox_enabled:help'),
]);
