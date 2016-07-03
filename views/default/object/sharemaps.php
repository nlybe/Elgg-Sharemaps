<?php
/**
 * Elgg Sharemaps Plugin
 * @package sharemaps 
 */

$full = elgg_extract('full_view', $vars, FALSE);
$sharemaps = elgg_extract('entity', $vars, FALSE);

if (!$sharemaps) {
    return TRUE;
}

$owner = $sharemaps->getOwnerEntity();
$container = $sharemaps->getContainerEntity();
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


$date = elgg_view_friendly_time($sharemaps->time_created);

$comments_count = $sharemaps->countComments();
//only display if there are commments
if ($comments_count != 0) {
    $text = elgg_echo("comments") . " ($comments_count)";
    $comments_link = elgg_view('output/url', array(
        'href' => $sharemaps->getURL() . '#comments',
        'text' => $text,
        'is_trusted' => true,
    ));
} 
else {
    $comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
    'entity' => $vars['entity'],
    'handler' => 'sharemaps',
    'sort_by' => 'priority',
    'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
    $metadata = '';
}



if ($full && !elgg_in_context('gallery')) {

    /************************ map start ************************/
    //Read map width and height from settings
    $map_width = sharemaps_get_map_width();
    $map_height = sharemaps_get_map_height();

    $mapbox = '';
    if(empty($sharemaps->originalfilename)) {  // in case of gmap link
       if(!empty($sharemaps->gmaplink)) {
            $mapbox .= '<br />';
            $mapbox .= '<div>';
            $mapbox .= '<iframe style="border:1px solid #eee;" width="'.$map_width.'" height="'.$map_height.'" scrolling="no" marginheight="0" marginwidth="0" src="'.$sharemaps->gmaplink.'&amp;output=embed"></iframe>';
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
            $vars['map_width'] = $map_width;
            $vars['map_height'] = $map_height;
            $mapbox = elgg_view('sharemaps/map_box', $vars);
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

    if (sharemaps_display_map_before_description()) {
        $text = $mapbox;  
        $text .= elgg_view('output/longtext', array('value' => $sharemaps->description));
    }
    else {
        $text = elgg_view('output/longtext', array('value' => $sharemaps->description));
        $text .= $mapbox;
    }
    
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
