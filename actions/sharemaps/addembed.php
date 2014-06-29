<?php
/**
 * Elgg map uploader/edit action
 *
 * @package ElggShareMaps
 */
elgg_load_library('elgg:sharemaps');

// Get variables
$gmaplink = get_input('gmaplink');
$title = get_input("title");
$desc = get_input("description");
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$guid = (int) get_input('file_guid');
$tags = get_input("tags");

if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('sharemaps');

// check whether this is a new map or an edit
$new_file = true;
if ($guid > 0) {
	$new_file = false;
}

// check if valid url
if (!is_valid_url_2($gmaplink))
{
        $error = elgg_echo('sharemaps:gmaplinknovalid');
        register_error($error);
        forward(REFERER);
}

// check if google maps url
$pos = strpos($gmaplink, 'https://maps.google.');
if ($pos === false) {
	$pos = strpos($gmaplink, 'https://www.google.');
}

if ($pos === false) {
	$error = elgg_echo('sharemaps:gmaplinknomapsgooglecom');
	register_error($error);
	forward(REFERER);
} else if ($pos != 0) {
	$error = '-->'.$pos;
	register_error($error);
	forward(REFERER);
}

/* obs
// check if valid url
if (!is_valid_url_2($gmaplink))
{
        $error = elgg_echo('sharemaps:gmaplinknovalid');
        register_error($error);
        forward(REFERER);
}

// check if google maps url
$pos = strpos($gmaplink, 'https://maps.google.');
if ($pos === false) {
        $error = elgg_echo('sharemaps:gmaplinknomapsgooglecom');
        register_error($error);
        forward(REFERER);
} else if ($pos != 0) {
        $error = '-->'.$pos;
        register_error($error);
        forward(REFERER);
}
*/

if ($new_file) {
    // nikos, must have a link
    if (empty($gmaplink)) {
            $error = elgg_echo('sharemaps:nogmaplink');
            register_error($error);
            forward(REFERER);
    }
    
    $sharemaps = new SharemapsPluginMap();
    $sharemaps->subtype = "sharemaps";

    // if no title on new upload, grab filename
    if (empty($title)) {
            $title = elgg_echo('sharemaps:dosekapoiotitle');
    }

} else {
    // load original file object
    $sharemaps = new SharemapsPluginMap($guid);
    if (!$sharemaps) {
            register_error(elgg_echo('sharemaps:cannotload'));
            forward(REFERER);
    }

    // user must be able to edit map
    if (!$sharemaps->canEdit()) {
            register_error(elgg_echo('sharemaps:noaccess'));
            forward(REFERER);
    }

    if (!$title) {
            // user blanked title, but we need one
            $title = $sharemaps->title;
    }
}

$sharemaps->title = $title;
$sharemaps->description = $desc;
$sharemaps->access_id = $access_id;
$sharemaps->container_guid = $container_guid;
$sharemaps->gmaplink = $gmaplink;

$tags = explode(",", $tags);
$sharemaps->tags = $tags;


// not saving a file but still need to save the entity to push attributes to database
$guid = $sharemaps->save();


// map saved so clear sticky form
elgg_clear_sticky_form('sharemaps');


// handle results differently for new files and file updates
if ($new_file) {
	if ($guid) {
		$message = elgg_echo("sharemaps:saved");
		system_message($message);
		add_to_river('river/object/sharemaps/create', 'create', elgg_get_logged_in_user_guid(), $sharemaps->guid);
	} else {
		// failed to save map object - nothing we can do about this
		$error = elgg_echo("sharemaps:uploadfailed");
		register_error($error);
	}

	forward($sharemaps->getURL());
} else {
	if ($guid) {
		system_message(elgg_echo("sharemaps:saved"));
	} else {
		register_error(elgg_echo("sharemaps:uploadfailed"));
	}

	forward($sharemaps->getURL());
}	
