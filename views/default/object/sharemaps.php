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
$owner_icon = elgg_view_entity_icon($owner, 'small');
//$file_icon = elgg_view_entity_icon($sharemaps, 'small');

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

	/************************ map start ************************/
	//Read map width and height from settings
	$mapwidth = trim(elgg_get_plugin_setting('map_width', 'sharemaps'));
	if (strripos($mapwidth, '%') === false) {
		if (is_numeric($mapwidth))  $mapwidth = $mapwidth.'px';
		else $mapwidth = '100%';
	} 

	$mapheight = trim(elgg_get_plugin_setting('map_height', 'sharemaps'));
	if (strripos($mapheight, '%') === false) {
		if (is_numeric($mapheight))  $mapheight = $mapheight.'px';
		else $mapheight = '500px';
	} 

	$mapbox = '';
	if(empty($sharemaps->originalfilename)) {  // in case of gmap link
	   if(!empty($sharemaps->gmaplink)) {
		   $mapbox .= '<br />';
		   $mapbox .= '<div>';
		   $mapbox .= '<iframe style="border:1px solid #eee;" width="'.$mapwidth.'" height="'.$mapheight.'" scrolling="no" marginheight="0" marginwidth="0" src="'.$sharemaps->gmaplink.'&amp;output=embed"></iframe>';
		   $mapbox .= '</div>';
	   }
	}
	else {  // kml or kmz or gpx file
	  
		$mapfile = $sharemaps->getFilenameOnFilestore();
		
		$gpxfile = true;   // by default we set that it is gpx file
		$pos = strripos($mapfile, '.gpx');
		if ($pos === false) {
			$gpxfile = false;
		}    
		
		// check if kml file
		if ($pos === false) {
			$pos = strripos($mapfile, '.kml');
		}    
		
		// check if kmz file
		if ($pos === false) {
			   $pos = strripos($mapfile, '.kmz');
		}  
	 
		if ($pos != false) {
			elgg_load_css('kmlcss');
			elgg_load_js('gkml');
			elgg_load_js('kml');

			//add time parameter to load kml map
			date_default_timezone_set('UTC');


	/* obs        
			// assign maps folder location elgg_get_plugins_path()
			$mapspath = elgg_get_plugins_path().'sharemaps/maps/';
			// remove files older than 15 minutes
			$files = glob($mapspath.'*'); // get all file names
			foreach($files as $file){ // iterate files
					if(is_file($file))	{
							$ttt = (time() - filemtime($file));
							if ($ttt > 900)	{
									unlink($file);
							}
					}
			} 
			 
			// create new kml file with random filename
			$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 20);
			$my_file = $randomString.'.kml';
			$handle = fopen($mapspath.$my_file, 'w') or die('Cannot open kml file. Make sure that folder mod/sharemaps/maps is writable from web server');
		   
			// write entity kml content to file
			// pro
			if ($gpxfile)   {
				$geometry = geoPHP::load(file_get_contents($mapfile), 'gpx');
				$gpx_output = $geometry->out('kml');     
				$header = '
				<?xml version="1.0" encoding="UTF-8"?>
				<kml xmlns="http://earth.google.com/kml/2.2">
					<Document>
						<name>'.$title.'</name>
							<description><![CDATA[]]></description>
								<Placemark>
				';
				$footer   =   '
								</Placemark>                
					</Document>
				</kml>              
				';            
				fwrite($handle, $header.$gpx_output.$footer);
			}
			else    {
				fwrite($handle, file_get_contents($mapfile));   // also in not pro
			}
			// pro        
			
			fclose($handle);
			*/ 
			//$kmlurl = elgg_get_site_url().'mod/sharemaps/maps/'.$my_file.'?t='.time();
			$kmlurl = elgg_get_site_url().'sharemaps/filepath/'.$sharemaps->guid.'?t='.time();
			$mapbox .= '<script language="javascript" type="text/javascript">';
			$mapbox .= 'window.onload = function () {';
			$mapbox .= 'initialize(encodeURI("'.$kmlurl.'"));';
			$mapbox .= '}';
			$mapbox .= '</script>';
			$mapbox .= '<br />';
			$mapbox .= '<div id="map_canvas" style="width:'.$mapwidth.'; height:'.$mapheight.'; border:1px solid #eee; "></div>';
		   
		}    
		
	}
	/************************ map end ************************/

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
	$text .= $mapbox;
	$body = "$text $extra";

	echo elgg_view('object/elements/full', array(
		'entity' => $sharemaps,
		'title' => false,
		'icon' => $owner_icon,
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

	echo elgg_view_image_block($owner_icon, $list_body);
}
