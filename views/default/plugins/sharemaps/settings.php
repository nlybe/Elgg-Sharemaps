<?php 
	
$plugin = $vars["entity"];

$potential_yes_no = array(
    SHAREMAPS_GENERAL_YES => elgg_echo('sharemaps:settings:yes'),
    SHAREMAPS_GENERAL_NO => elgg_echo('sharemaps:settings:no'),
);

// Google API
$google = elgg_view('input/text', array('name' => 'params[google_api_key]', 'value' => $plugin->google_api_key));
$google .= "<div class='elgg-subtext'>" . elgg_echo('sharemaps:settings:google_api_key:clickhere') . "</div>";
echo elgg_view_module("inline", elgg_echo('sharemaps:settings:google_api_key'), $google);

// Map width
$map_width = elgg_view('input/text', array('name' => 'params[map_width]', 'value' => $plugin->map_width));
$map_width .= "<div class='elgg-subtext'>" . elgg_echo('sharemaps:settings:map_width:how') . "</div>";
echo elgg_view_module("inline", elgg_echo('sharemaps:settings:map_width'), $map_width);	

// Map height
$map_height = elgg_view('input/text', array('name' => 'params[map_height]', 'value' => $plugin->map_height));
$map_height .= "<div class='elgg-subtext'>" . elgg_echo('sharemaps:settings:map_height:how') . "</div>";
echo elgg_view_module("inline", elgg_echo('sharemaps:settings:map_height'), $map_height);	

// allow or not to insert google maps links 
$allow_gmaps_links = $plugin->allow_gmaps_links;
if(empty($allow_gmaps_links)){
	$allow_gmaps_links = SHAREMAPS_GENERAL_YES;
}    
$allow_gmaps_links_output = elgg_view('input/dropdown', array('name' => 'params[allow_gmaps_links]', 'value' => $allow_gmaps_links, 'options_values' => $potential_yes_no));
echo elgg_view_module("inline", elgg_echo('sharemaps:settings:allow_gmaps_links'), $allow_gmaps_links_output);

        
	
