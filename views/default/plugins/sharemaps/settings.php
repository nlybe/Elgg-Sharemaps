<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */
	
$plugin = elgg_get_plugin_from_id('sharemaps');

$potential_yes_no = array(
    SHAREMAPS_GENERAL_YES => elgg_echo('sharemaps:settings:yes'),
    SHAREMAPS_GENERAL_NO => elgg_echo('sharemaps:settings:no'),
);

$potential_before_after = array(
    SHAREMAPS_GENERAL_BEFORE => elgg_echo('sharemaps:settings:before'),
    SHAREMAPS_GENERAL_AFTER => elgg_echo('sharemaps:settings:after'),
);

// Google API
echo elgg_format_element('div', [], elgg_view_input('text', array(
    'name' => 'params[google_api_key]',
    'value' => $plugin->google_api_key,
    'label' => elgg_echo('sharemaps:settings:google_api_key'),
    'help' => elgg_echo('sharemaps:settings:google_api_key:help'),
)));

// default map location coords
echo elgg_format_element('div', [], elgg_view_input('text', array(
    'name' => 'params[default_coords]',
    'value' => $plugin->default_coords,
    'label' => elgg_echo('sharemaps:settings:default_coords'),
    'help' => elgg_echo('sharemaps:settings:default_coords:help'),
)));

// Map width
echo elgg_format_element('div', [], elgg_view_input('text', array(
    'name' => 'params[map_width]',
    'value' => $plugin->map_width,
    'label' => elgg_echo('sharemaps:settings:map_width'),
    'help' => elgg_echo('sharemaps:settings:map_width:help'),
    'style' => 'width: 200px;',
)));

// Map height
echo elgg_format_element('div', [], elgg_view_input('text', array(
    'name' => 'params[map_height]',
    'value' => $plugin->map_height,
    'label' => elgg_echo('sharemaps:settings:map_height'),
    'help' => elgg_echo('sharemaps:settings:map_height:help'),
    'style' => 'width: 200px;',
)));

// allow or not the upload of maps
$map_upload = $plugin->map_upload;
if(empty($map_upload)){
    $map_upload = SHAREMAPS_GENERAL_YES;
}  
echo elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[map_upload]',
    'value' => $map_upload,
    'options_values' => $potential_yes_no,
    'label' => elgg_echo('sharemaps:settings:map_upload'),
    'help' => elgg_echo('sharemaps:settings:map_upload:help'),
)));

// allow or not to insert google maps links 
$map_creation = $plugin->map_creation;
if(empty($map_creation)){
    $map_creation = SHAREMAPS_GENERAL_YES;
}  
echo elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[map_creation]',
    'value' => $map_creation,
    'options_values' => $potential_yes_no,
    'label' => elgg_echo('sharemaps:settings:map_creation'),
    'help' => elgg_echo('sharemaps:settings:map_creation:help'),
)));

// allow or not to insert google maps links 
$gmaps_links = $plugin->gmaps_links;
if(empty($gmaps_links)){
    $gmaps_links = SHAREMAPS_GENERAL_NO;
}  
echo elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[gmaps_links]',
    'value' => $gmaps_links,
    'options_values' => $potential_yes_no,
    'label' => elgg_echo('sharemaps:settings:gmaps_links'),
    'help' => elgg_echo('sharemaps:settings:gmaps_links:help'),
)));

// select where to load map regarding description
$map_description = $plugin->map_description;
if(empty($map_description)){
    $map_description = SHAREMAPS_GENERAL_BEFORE;
}  
echo elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[map_description]',
    'value' => $map_description,
    'options_values' => $potential_before_after,
    'label' => elgg_echo('sharemaps:settings:map_description'),
    'help' => elgg_echo('sharemaps:settings:map_description:help'),
)));
