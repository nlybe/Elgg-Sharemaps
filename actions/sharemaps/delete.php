<?php
/**
* Elgg map delete
* 
* @package ElggShareMaps
*/

$guid = (int) get_input('guid');
        
$sharemaps = new SharemapsPluginMap($guid);
if (!$sharemaps->guid) {
	register_error(elgg_echo("sharemaps:deletefailed"));
	forward('sharemaps/all');
}

if (!$sharemaps->canEdit()) {
	register_error(elgg_echo("sharemaps:deletefailed"));
	forward($sharemaps->getURL());
}

$container = $sharemaps->getContainerEntity();

$fname = $sharemaps->getFilename();
if(empty($fname)) {
    $gmap = new ElggObject($guid);
    
    if (!$gmap->delete()) {
            register_error(elgg_echo("sharemaps:deletefailed"));
    } else { 
            system_message(elgg_echo("sharemaps:deleted"));
    }    
}
else {
    if (!$sharemaps->delete()) {
            register_error(elgg_echo("sharemaps:deletefailed"));
    } else {
            system_message(elgg_echo("sharemaps:deleted"));
    }
}

if (elgg_instanceof($container, 'group')) {
	forward("sharemaps/group/$container->guid/all");
} else {
	forward("sharemaps/owner/$container->username");
}
