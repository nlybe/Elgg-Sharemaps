<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

use Sharemaps\SharemapsOptions;

if (!elgg_is_xhr()) {
    register_error('Sorry, Ajax only!');
    forward(REFERRER);
}

$result = [
    'error' => false,
];

$guid = (int) get_input('guid');
$entity = get_entity($guid);
if (!$entity instanceof ElggMap || !$entity->canEdit()) {
    $result['error'] = true;
    $result['status_msg'] = elgg_echo('sharemaps:save:failed');
    echo json_encode($result);
    exit;
}

// check if upload attempted and failed
$uploaded_file = elgg_get_uploaded_file('file', false);
if ($uploaded_file && !$uploaded_file->isValid()) {
    $result['error'] = true;
    $result['status_msg'] = elgg_get_friendly_upload_error($uploaded_file->getError());
    echo json_encode($result);
    exit;
}

if ($uploaded_file) {
    $supported_mimes = SharemapsOptions::getAllowedMapFiles();

    $mime_type = ElggFile::detectMimeType($uploaded_file->getPathname(), $uploaded_file->getClientMimeType());
    if (!in_array($mime_type, $supported_mimes)) {
        $result['error'] = true;
        $result['status_msg'] = elgg_echo('sharemaps:save:file:invalid');
        echo json_encode($result);
        exit;
    }    
}

if ($uploaded_file && $uploaded_file->isValid()) {
	// save master file
	if (!$entity->acceptUploadedFile($uploaded_file)) {
        $result['error'] = true;
        $result['status_msg'] = elgg_echo('sharemaps:file:uploadfailed');
        echo json_encode($result);
        exit;
	}
} 

$result['status_msg'] = elgg_echo('sharemaps:upload:success');
$result['map_type'] = $entity->getMapType();

echo json_encode($result);
exit;
