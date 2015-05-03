<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */
 
elgg_load_library('elgg:sharemaps');

// Get variables
$title = get_input("title");
$desc = get_input("description");
$dm_markers = get_input('dm_markers');
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$guid = (int) get_input('guid');
$tags = get_input("tags");

$map_title = isset($_POST['map_title']) ? $_POST['map_title'] : '';
$map_description = isset($_POST['map_description']) ? $_POST['map_description'] : '';
$marker_title = isset($_POST['marker_title']) ? $_POST['marker_title'] : '';
$marker_coords = isset($_POST['marker_coords']) ? $_POST['marker_coords'] : '';
$line_title = isset($_POST['line_title']) ? $_POST['line_title'] : '';
$line_coords = isset($_POST['line_coords']) ? $_POST['line_coords'] : '';
$poly_title = isset($_POST['poly_title']) ? $_POST['poly_title'] : '';
$poly_coords = isset($_POST['poly_coords']) ? $_POST['poly_coords'] : '';
$rect_title = isset($_POST['rect_title']) ? $_POST['rect_title'] : '';
$rect_coords = isset($_POST['rect_coords']) ? $_POST['rect_coords'] : '';
$circle_title = isset($_POST['circle_title']) ? $_POST['circle_title'] : '';
$circle_coords = isset($_POST['circle_coords']) ? $_POST['circle_coords'] : '';

if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('drawmap');

if (!$title) {
	register_error(elgg_echo('sharemaps:dosekapoiotitle'));
	forward(REFERER);
}

// check whether this is a new map or an edit
$new_map = true;
if ($guid > 0) {
	$new_map = false;
}

if ($new_map) {
    $dmap = new Drawmap();
    $dmap->subtype = "drawmap";
} else {
    // load original file object
    $dmap = new Drawmap($guid);
    if (!$dmap) {
		register_error(elgg_echo('sharemaps:cannotload'));
		forward(REFERER);
    }
    
    // user must be able to edit map
    if (!$dmap->canEdit()) {
		register_error(elgg_echo('sharemaps:noaccess'));
		forward(REFERER);
    }

    if (!$title) {
		// user blanked title, but we need one
		$title = $dmap->title;
    }
    
	// delete the objects of the map
	$delete_objects = $dmap->deleteMapObjects();    
}

$dmap->title = $title;
$dmap->description = $desc;
$dmap->access_id = $access_id;
$dmap->container_guid = $container_guid;
$dmap->dm_markers = $dm_markers;
$tags = explode(",", $tags);
$dmap->tags = $tags;

$guid = $dmap->save();

// map saved so clear sticky form
elgg_clear_sticky_form('drawmap');


if ($guid) {
	if ($marker_title) {
		foreach( $marker_title as $key => $n ) {	// new map marker record created
			$dmap_object = new DrawmapObject();
			$dmap_object->title = $n;
			$dmap_object->coords = $marker_coords[$key];
			$dmap_object->object_id = SHAREMAPS_MAP_OBJECT_MARKER;
			$dmap_object->map_guid = $dmap->guid;
			$dmap_object->access_id = $access_id;
			
			if (!$dmap_object->save())	{
				system_message(elgg_echo("sharemaps:drawmap:object_not_saved"));
			}
		}
	}
	
	if ($line_title) {	
		foreach( $line_title as $key => $n ) {	// new map polylines record created
			$dmap_object = new DrawmapObject();
			$dmap_object->title = $n;
			$dmap_object->coords = $line_coords[$key];
			$dmap_object->object_id = SHAREMAPS_MAP_OBJECT_POLYLINE;
			$dmap_object->map_guid = $dmap->guid;
			$dmap_object->access_id = $access_id;
			
			if (!$dmap_object->save())	{
				system_message(elgg_echo("sharemaps:drawmap:object_not_saved"));
			}
		}
	}
		
	if ($poly_title) {
		foreach( $poly_title as $key => $n ) {	// new map polygons record created
			$dmap_object = new DrawmapObject();
			$dmap_object->title = $n;
			$dmap_object->coords = $poly_coords[$key];
			$dmap_object->object_id = SHAREMAPS_MAP_OBJECT_POLYGON;
			$dmap_object->map_guid = $dmap->guid;
			$dmap_object->access_id = $access_id;
			
			if (!$dmap_object->save())	{
				system_message(elgg_echo("sharemaps:drawmap:object_not_saved"));
			}
		}
	}
		
	if ($rect_title) {
		foreach( $rect_title as $key => $n ) {	// new map rectangles record created
			$dmap_object = new DrawmapObject();
			$dmap_object->title = $n;
			$dmap_object->coords = $rect_coords[$key];
			$dmap_object->object_id = SHAREMAPS_MAP_OBJECT_RECTANGLE;
			$dmap_object->map_guid = $dmap->guid;
			$dmap_object->access_id = $access_id;
			
			if (!$dmap_object->save())	{
				system_message(elgg_echo("sharemaps:drawmap:object_not_saved"));
			}
		}
	}
		
	if ($circle_title) {
		foreach( $circle_title as $key => $n ) {	// new map circles record created
			$dmap_object = new DrawmapObject();
			$dmap_object->title = $n;
			$dmap_object->coords = $circle_coords[$key];
			$dmap_object->object_id = SHAREMAPS_MAP_OBJECT_CIRCLE;
			$dmap_object->map_guid = $dmap->guid;
			$dmap_object->access_id = $access_id;
			
			if (!$dmap_object->save())	{
				system_message(elgg_echo("sharemaps:drawmap:object_not_saved"));
			}
		}
	}
			
	if ($new_map) {
		elgg_create_river_item(array(
			'view' => 'river/object/sharemaps/create',
			'action_type' => 'create',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $dmap->guid,
		));
	}
	
	system_message(elgg_echo("sharemaps:saved"));
} else {
	register_error(elgg_echo("sharemaps:uploadfailed"));
}

forward($dmap->getURL());
