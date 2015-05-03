<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */
 
elgg_load_js('sharemaps_gkml');
elgg_load_js('sharemaps_gmaps');
elgg_load_js('sharemaps_prettify');
elgg_load_js('sharemaps_drawonmaps');
elgg_load_js('sharemaps_drawonmaps_elgg');
elgg_load_css('sharemaps_drawonmaps');

$title = elgg_extract('title', $vars, '');
$description = elgg_extract('description', $vars, '');
$dm_markers = elgg_extract('dm_markers', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
if (!$container_guid) {
	$container_guid = elgg_get_logged_in_user_guid();
}
$guid = elgg_extract('guid', $vars, null);

// load the objects of the map
$map_objects = elgg_extract('map_objects', $vars, null);

$map_js = '';
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

?>
	
<?php echo $map_js; ?>
<div>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title, 'id' => 'map_title')); ?>
</div>
<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $description)); ?>
</div>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>

	<div class="container">
		<h4 class="doc_title"><?php echo elgg_echo('sharemaps:drawmap:draw'); ?></h4>
		<!-- Main component for a primary marketing message or call to action -->
		<div class="row">
			<div class="searchbox" >
				<div class="form-group input">
					<input type="text" class="form-control" id="address" name="address" placeholder="Enter city or address">
					<input type="button" class="btn btn-primary" value="Search" onClick="searchLocation();"/>
				</div>					
			</div>
			<div id="basic_options">
				<div class="radio">
					<label for="drawwhat_markers"><input type="radio" name="drawwhat" id="drawwhat_markers" value="markers" checked>Markers</label>
					<label for="drawwhat_line"><input type="radio" name="drawwhat" id="drawwhat_line" value="line" >Line</label>
					<label for="drawwhat_polygon"><input type="radio" name="drawwhat" id="drawwhat_polygon" value="polygon">Polygon</label>     	
					<label for="drawwhat_rectangle"><input type="radio" name="drawwhat" id="drawwhat_rectangle" value="rectangle">Rectangle</label>    
					<label for="drawwhat_circle"><input type="radio" name="drawwhat" id="drawwhat_circle" value="circle">Circle</label>    
					<div id="helpbox" class="text-info"></div>	  
				</div>
			</div>
			<div id="basic_buttons">
				<button type="button" id="drawwhat_clearall" class="btn btn-danger">Clear All</button>
				<button type="button" disabled="disabled" id="add_btn" class="btn btn-primary">Add</button> 
				<button type="button" disabled="disabled" id="save_btn" class="btn btn-success">Save</button> 
				<button type="button" disabled="disabled" id="cancel_editing" class="btn btn-warning">Cancel</button>
			</div>
		</div>
		<div class="row">
			<div class="popin">
				<div id="map"></div>
			</div>
		</div>
		<div class="row" id="map_form">
			<div class="row" id="allmarks"></div>  
			<div class="row" id="map_info"></div>  
		</div> 
	</div> <!-- /container -->
	
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => elgg_echo("sharemaps:drawmap:save"), 'id' => 'addmap_btn', 'onClick' =>'return validateDrawForm("'.elgg_echo('sharemaps:dosekapoiotitle').'");'));

?>
</div>
