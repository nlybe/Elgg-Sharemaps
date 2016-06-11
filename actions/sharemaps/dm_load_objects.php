<?php
/**
 * Elgg Sharemaps Plugin
 * @package sharemaps 
 */
  
if (!elgg_is_xhr()) {
    register_error('Sorry, Ajax only!');
    forward(REFERRER);
}

// get variables
$map_guid = get_input("map_guid");
$entity = get_entity($map_guid);

$content = '';  
$has_error = false;
if (elgg_instanceof($entity, 'object', 'drawmap')) {
    $map_objects = $entity->getMapObjects(true);
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
        
        $content = $map_js;  
    }
}    
else {
    $has_error = true;
	$error_msg = elgg_echo('sharemaps:invalid:entity');
}

$result = array(
    'error' => $has_error,
    'content' => $content,
    'error_msg' => $error_msg,
    'map_objects' => json_encode($map_objects),
);
error_log(json_encode($map_objects));
// release variables
unset($map_objects);
unset($entity);    
				
echo json_encode($result);
exit;
