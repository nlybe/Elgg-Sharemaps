<?php 
	
<<<<<<< HEAD
$plugin = $vars["entity"];

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
=======
	$plugin = $vars["entity"];
	
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
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
	