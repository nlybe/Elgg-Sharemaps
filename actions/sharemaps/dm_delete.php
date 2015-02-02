<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

$guid = (int) get_input('guid');
        
$dmap = new Drawmap($guid);
if (!$dmap->guid) {
	register_error(elgg_echo("sharemaps:deletefailed"));
	forward('sharemaps/all');
}

if (!$dmap->canEdit()) {
	register_error(elgg_echo("sharemaps:deletefailed"));
	forward($dmap->getURL());
}

$container = $dmap->getContainerEntity();

// delete the objects of the map
$delete_objects = $dmap->deleteMapObjects(); 

if (!$dmap->delete()) {
	register_error(elgg_echo("sharemaps:deletefailed"));
} else {
	system_message(elgg_echo("sharemaps:deleted"));
}

if (elgg_instanceof($container, 'group')) {
	forward("sharemaps/group/$container->guid/all");
} else {
	forward("sharemaps/owner/$container->username");
}
