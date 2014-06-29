<?php
/**
 * Elgg map thumbnail
 *
 * @package ElggShareMaps
 */

// Get engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Get map GUID
$file_guid = (int) get_input('file_guid', 0);

// Get map thumbnail size
$size = get_input('size', 'small');

$sharemaps = get_entity($file_guid);
if (!$sharemaps || $sharemaps->getSubtype() != "sharemaps") {
	exit;
}

$simpletype = $sharemaps->simpletype;
if ($simpletype == "image") {

	// Get map thumbnail
	switch ($size) {
		case "small":
			$thumbfile = $sharemaps->thumbnail;
			break;
		case "medium":
			$thumbfile = $sharemaps->smallthumb;
			break;
		case "large":
		default:
			$thumbfile = $sharemaps->largethumb;
			break;
	}

	// Grab the map
	if ($thumbfile && !empty($thumbfile)) {
		$readfile = new ElggFile();
		$readfile->owner_guid = $sharemaps->owner_guid;
		$readfile->setFilename($thumbfile);
		$mime = $sharemaps->getMimeType();
		$contents = $readfile->grabFile();

		// caching images for 10 days
		header("Content-type: $mime");
		header('Expires: ' . date('r',time() + 864000));
		header("Pragma: public", true);
		header("Cache-Control: public", true);
		header("Content-Length: " . strlen($contents));

		echo $contents;
		exit;
	}
}
