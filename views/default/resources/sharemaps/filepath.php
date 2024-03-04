<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

$guid = elgg_extract('guid', $vars, '');

// get the file
$entity = elgg_call(ELGG_IGNORE_ACCESS, function() use ($guid) {
	return get_entity($guid);
});

if (!$entity) {
	register_error(elgg_echo("sharemaps:download:failed"));
	forward();
}

$mime = $entity->getMimeType();
if (!$mime) {
	$mime = "application/octet-stream";
}

$filename = $entity->originalfilename;

// fix for IE https issue
header("Pragma: public");

header("Content-type: $mime");
header("Content-Disposition: attachment; filename=\"$filename\"");

ob_clean();
flush();
readfile($entity->getFilenameOnFilestore());

exit;
