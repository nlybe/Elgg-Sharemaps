<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

$guid = elgg_extract('guid', $vars, '');

// set ignore access for loading non public objexts
$ia = elgg_get_ignore_access();
elgg_set_ignore_access(true);
				
// get the file
$entity = new ElggMap($guid);
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

// restore ignore access
elgg_set_ignore_access($ia);

exit;
