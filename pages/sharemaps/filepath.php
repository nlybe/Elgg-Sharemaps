<?php
/**
 * Elgg map download.
 *
 * @package ElggShareMaps
 */

// Get the guid
$file_guid = get_input("guid");

<<<<<<< HEAD
// set ignore access for loading non public objexts
$ia = elgg_get_ignore_access();
elgg_set_ignore_access(true);
				
=======
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
// Read file
$sharemaps = get_entity($file_guid);
if (!$sharemaps) {
	register_error(elgg_echo("sharemaps:downloadfailed"));
	forward();
}
<<<<<<< HEAD
  
=======

>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
$sharemaps = new SharemapsPluginMap($file_guid);

$mime = $sharemaps->getMimeType();
if (!$mime) {
	$mime = "application/octet-stream";
}

$filename = $sharemaps->originalfilename;

<<<<<<< HEAD
//error_log('------------------>'.$filename);
			
=======
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
// fix for IE https issue
header("Pragma: public");

header("Content-type: $mime");
if (strpos($mime, "image/") !== false || $mime == "application/pdf") {
	header("Content-Disposition: inline; filename=\"$filename\"");
} else {
	header("Content-Disposition: attachment; filename=\"$filename\"");
}

ob_clean();
flush();
readfile($sharemaps->getFilenameOnFilestore());
<<<<<<< HEAD

// restore ignore access
elgg_set_ignore_access($ia);
=======
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
exit;
