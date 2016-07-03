<?php
/**
 * Elgg map download.
 *
 * @package ElggShareMaps
 */

// Get the guid
$file_guid = elgg_extract('guid', $vars, '');

// set ignore access for loading non public objexts
$ia = elgg_get_ignore_access();
elgg_set_ignore_access(true);
				
// Read file
$sharemaps = get_entity($file_guid);
if (!$sharemaps) {
	register_error(elgg_echo("sharemaps:downloadfailed"));
	forward();
}
  
$sharemaps = new SharemapsPluginMap($file_guid);

$mime = $sharemaps->getMimeType();
if (!$mime) {
	$mime = "application/octet-stream";
}

$filename = $sharemaps->originalfilename;

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

// restore ignore access
elgg_set_ignore_access($ia);
exit;
