<?php
/**
 * Elgg map uploader/edit action
 *
 * @package ElggShareMaps
 */
<<<<<<< HEAD
 
elgg_load_library('elgg:sharemapsgeophp'); 
=======
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee

// Get variables
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

// check if upload failed
if (!empty($_FILES['upload']['name']) && $_FILES['upload']['error'] != 0) {
	register_error(elgg_echo('sharemaps:cannotload'));
	forward(REFERER);
}

// check whether this is a new map or an edit
$new_file = true;
if ($guid > 0) {
	$new_file = false;
}

if ($new_file) {
    // must have a file if a new file upload
    if (empty($_FILES['upload']['name'])) {
            $error = elgg_echo('sharemaps:nofile');
            register_error($error);
            forward(REFERER);
    }

    // check if kml file
    $mapfile = $_FILES['upload']['name'];
    $pos = strripos($mapfile, '.kml');
    
    if ($pos === false) {
<<<<<<< HEAD
		$pos = strripos($mapfile, '.kmz');
    }
    
    if ($pos === false) {
        $pos = strripos($mapfile, '.gpx');
    }    

    if ($pos === false) {
		$error = elgg_echo('sharemaps:novalidfile');  // pro
		register_error($error);
		forward(REFERER);
=======
            $pos = strripos($mapfile, '.kmz');
    }

    if ($pos === false) {
            $error = elgg_echo('sharemaps:nokmlfile');
            register_error($error);
            forward(REFERER);
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
    } 

    $sharemaps = new SharemapsPluginMap();
    $sharemaps->subtype = "sharemaps";

    // if no title on new upload, grab filename
    if (empty($title)) {
            $title = $_FILES['upload']['name'];
    }
<<<<<<< HEAD
 
=======

>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
} else {
    // check if updated file is valid
    if (!empty($_FILES['upload']['name'])) {
        // check if kml file
        $mapfile = $_FILES['upload']['name'];
        $pos = strripos($mapfile, '.kml');

        if ($pos === false) {
                $pos = strripos($mapfile, '.kmz');
        }

        if ($pos === false) {
<<<<<<< HEAD
                $pos = strripos($mapfile, '.gpx');
        }    

        if ($pos === false) {
=======
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
                $error = elgg_echo('sharemaps:novalidfile'); 
                register_error($error);
                forward(REFERER);
        } 
    }
    
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

<<<<<<< HEAD
$gpxfile = true;   // by default we set that it is gpx file
$pos = strripos($mapfile, '.gpx');
if ($pos === false) {
	$gpxfile = false;
}    

=======
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
$sharemaps->title = $title;
$sharemaps->description = $desc;
$sharemaps->access_id = $access_id;
$sharemaps->container_guid = $container_guid;

$tags = explode(",", $tags);
$sharemaps->tags = $tags;

// we have a file upload, so process it
if (isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name'])) {

	$prefix = "sharemaps/";

	// if previous file, delete it
	if ($new_file == false) {
		$filename = $sharemaps->getFilenameOnFilestore();
		if (file_exists($filename)) {
			unlink($filename);
		}

		// use same filename on the disk - ensures thumbnails are overwritten
		$filestorename = $sharemaps->getFilename();
		$filestorename = elgg_substr($filestorename, elgg_strlen($prefix));
	} else {
		$filestorename = elgg_strtolower(time().$_FILES['upload']['name']);
	}

	$sharemaps->setFilename($prefix . $filestorename);
	$mime_type = ElggFile::detectMimeType($_FILES['upload']['tmp_name'], $_FILES['upload']['type']);

	$sharemaps->setMimeType($mime_type);
	$sharemaps->originalfilename = $_FILES['upload']['name'];
	$sharemaps->simpletype = sharemaps_get_simple_type($mime_type);

	// Open the file to guarantee the directory exists
	$sharemaps->open("write");
	$sharemaps->close();
	move_uploaded_file($_FILES['upload']['tmp_name'], $sharemaps->getFilenameOnFilestore());

	$guid = $sharemaps->save();
<<<<<<< HEAD
/*
	// if original file is gpx, save also as kml
	if ($gpxfile)   {
	
		$geometry = geoPHP::load(file_get_contents($sharemaps->getFilenameOnFilestore()), 'gpx');
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
		$kmlfile = new ElggFile();
		$kmlfile->setMimeType($_FILES['upload']['type']);

		$kmlfile->setFilename($prefix.$filestorename.'.kml');
		$kmlfile->open("write");
		$kmlfile->write($header.$gpx_output.$footer);
		$kmlfile->close();
	}
*/
}
else {
=======

	// if image, we need to create thumbnails (this should be moved into a function)
	if ($guid && $sharemaps->simpletype == "image") {
		$sharemaps->icontime = time();
		
		$thumbnail = get_resized_image_from_existing_file($sharemaps->getFilenameOnFilestore(), 60, 60, true);
		if ($thumbnail) {
			$thumb = new ElggFile();
			$thumb->setMimeType($_FILES['upload']['type']);

			$thumb->setFilename($prefix."thumb".$filestorename);
			$thumb->open("write");
			$thumb->write($thumbnail);
			$thumb->close();

			$sharemaps->thumbnail = $prefix."thumb".$filestorename;
			unset($thumbnail);
		}

		$thumbsmall = get_resized_image_from_existing_file($sharemaps->getFilenameOnFilestore(), 153, 153, true);
		if ($thumbsmall) {
			$thumb->setFilename($prefix."smallthumb".$filestorename);
			$thumb->open("write");
			$thumb->write($thumbsmall);
			$thumb->close();
			$sharemaps->smallthumb = $prefix."smallthumb".$filestorename;
			unset($thumbsmall);
		}

		$thumblarge = get_resized_image_from_existing_file($sharemaps->getFilenameOnFilestore(), 600, 600, false);
		if ($thumblarge) {
			$thumb->setFilename($prefix."largethumb".$filestorename);
			$thumb->open("write");
			$thumb->write($thumblarge);
			$thumb->close();
			$sharemaps->largethumb = $prefix."largethumb".$filestorename;
			unset($thumblarge);
		}
	}
} else {
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
	// not saving a file but still need to save the entity to push attributes to database
	$sharemaps->save();
}

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
<<<<<<< HEAD
	
	forward($sharemaps->getURL());
=======

	$container = get_entity($container_guid);
	if (elgg_instanceof($container, 'group')) {
		forward("sharemaps/group/$container->guid/all");
	} else {
		forward("sharemaps/owner/$container->username");
	}

>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
} else {
	if ($guid) {
		system_message(elgg_echo("sharemaps:saved"));
	} else {
		register_error(elgg_echo("sharemaps:uploadfailed"));
	}

	forward($sharemaps->getURL());
}	
