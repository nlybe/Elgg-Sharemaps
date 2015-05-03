<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

$full = elgg_extract('full_view', $vars, FALSE);

if ($full && !elgg_in_context('gallery')) {
	elgg_load_js('sharemaps_gkml');
	elgg_load_js('sharemaps_gmaps');
	elgg_load_js('sharemaps_prettify');
	elgg_load_js('sharemaps_drawonmaps');
	elgg_load_css('sharemaps_drawonmaps');
}

$entity_unit = elgg_extract('entity', $vars, FALSE);

if (!$entity_unit) {
	return TRUE;
}

$owner = $entity_unit->getOwnerEntity();
$container = $entity_unit->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = elgg_get_excerpt($entity_unit->description);

$owner_link = elgg_view('output/url', array(
	'href' => "sharemaps/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$owner_icon = elgg_view_entity_icon($owner, 'small');

$date = elgg_view_friendly_time($entity_unit->time_created);

$comments_count = $entity_unit->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $entity_unit->getURL() . '#file-comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'sharemaps/drawmap',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

//Read map width and height from settings
$mapwidth = sharemaps_get_map_width();
$mapheight = sharemaps_get_map_height();

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full && !elgg_in_context('gallery')) {

	$map_js = '';
	if (elgg_instanceof($entity_unit, 'object', 'drawmap')) {
		$map_objects = $entity_unit->getMapObjects();
		if ($map_objects) {
			$map_js .= '
			<script>
				$(document).ready(function(){
					var objectsBounds = new google.maps.LatLngBounds();
			';
			foreach ($map_objects as $obj)	{
				$map_js .= '
					var tmp_coords = [];
					var coords = "'.$obj->coords.'";	
				';	
				if ($obj->object_id == 1)  {  // load markers
					$map_js .= '
						tmp_coords = getDataFromArray(coords);					
						loadMarker(tmp_coords[0], tmp_coords[1], "'.$obj->title.'");
						var myLatlng = new google.maps.LatLng(tmp_coords[0],tmp_coords[1]);
						objectsBounds.extend(myLatlng);
					';					
				}
				else if ($obj->object_id == 2)  {  // load polylines 
					$map_js .= '
						tmp_coords = getPathFromCoordsArray(coords);
						var getbounds = loadPolyline(tmp_coords, "'.$obj->title.'");
						objectsBounds.union(getbounds);
					';
				}
				else if ($obj->object_id == 3)  {  // load polygons
					$map_js .= '
						tmp_coords = getPathFromCoordsArray(coords);
						var getbounds = loadPolygon(tmp_coords, "'.$obj->title.'");
						objectsBounds.union(getbounds);
					';
				}
				else if ($obj->object_id == 4)  {  // load rectangles
					$map_js .= '
						tmp_coords = getDataFromArray(coords);
						path_rect = [];
						path_rect.push(addCoordsToArray(tmp_coords[0], tmp_coords[1]));
						path_rect.push(addCoordsToArray(tmp_coords[2], tmp_coords[3]));					
						var getbounds = loadRectangle(path_rect, "'.$obj->title.'");
						objectsBounds.union(getbounds);
					';
				}
				else if ($obj->object_id == 5)  {  // load circles
					$map_js .= '
						tmp_coords = getDataFromArray(coords);
						var getbounds = loadCircle(tmp_coords[0], tmp_coords[1], parseInt(tmp_coords[2]), "'.$obj->title.'");
						objectsBounds.union(getbounds);
					';
				}		
			}
			$map_js .= '
					// set map visible with all shapes
					map.fitBounds(objectsBounds);
				});
			</script>
			';			
			
		}	
	}

	$params = array(
		'entity' => $entity_unit,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	$text = elgg_view('output/longtext', array('value' => $entity_unit->description));
	$text .= $map_js;
	$text .= '
		<div class="row">
			<div class="popin">
				<div id="map" style="width:'.$mapwidth.'; height:'.$mapheight.';"></div>
			</div>
		</div>
	';	
	
	$body = "$text $extra";

	echo elgg_view('object/elements/full', array(
		'entity' => $entity_unit,
		'title' => false,
		'icon' => $owner_icon,
		'summary' => $summary,
		'body' => $body,
	));

} elseif (elgg_in_context('gallery')) {
	echo '<div class="file-gallery-item">';
	echo "<h3>" . $entity_unit->title . "</h3>";
	echo elgg_view_entity_icon($entity_unit, 'medium');
	echo "<p class='subtitle'>$owner_link $date</p>";
	echo '</div>';
} else {
	// brief view

	$params = array(
		'entity' => $entity_unit,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($owner_icon, $list_body);
}
