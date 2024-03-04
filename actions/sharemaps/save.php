<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

// Get variables
$title = trim(get_input("title"));
$description = get_input("description");
$map_objects = get_input("map_objects");
$access_id = (int) get_input("access_id");
$tags = get_input("tags");
$guid = (int) get_input('file_guid');
$container_guid = (int) get_input('container_guid', elgg_get_logged_in_user_guid());
$comments_on = get_input("comments_on");

elgg_make_sticky_form('sharemaps');

if (!$title) {
	return elgg_error_response(elgg_echo('sharemaps:save:missing_title'));
}

if ($guid == 0) {
    $entity = new ElggMap;
    $entity->subtype = ElggMap::SUBTYPE;
	$entity->container_guid = $container_guid;
	$new = true;
} 
else {
	$entity = get_entity($guid);
	if (!$entity instanceof ElggMap || !$entity->canEdit()) {
		return elgg_error_response(elgg_echo('sharemaps:save:failed'));
	}
}

$entity->title = $title;
$entity->description = $description;
$entity->map_objects = $map_objects;
$entity->access_id = $access_id;
$entity->tags = string_to_tag_array($tags);
$entity->comments_on = $comments_on;

if (!$entity->save()) {
	return elgg_error_response(elgg_echo('sharemaps:save:failed'));
}

// map saved so clear sticky form
elgg_clear_sticky_form('sharemaps');

$redirect_url = $entity->getURL();

//add to river only if new
if ($new) {
	elgg_create_river_item([
		'view' => 'river/object/sharemaps/create',
		'action_type' => 'create',
		'object_guid' => $entity->getGUID(),
	]);

	// also change redirect_url
	$redirect_url = elgg_generate_url('edit:object:sharemaps', ['guid' => $entity->guid]);
}

return elgg_ok_response('', elgg_echo('sharemaps:save:success'), $redirect_url);

