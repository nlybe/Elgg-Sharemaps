<?php
/**
 * Elgg map download.
 * 
 * @package ElggShareMaps
 */
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Get the guid
$file_guid = get_input("file_guid");

forward("sharemaps/download/$file_guid");
