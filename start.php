<?php
/**
 * Elgg sharemaps plugin
 * @package ElggShareMaps
 */

//http://gmaps-samples-v3.googlecode.com/svn/trunk/poly/poly_edit.html

elgg_register_event_handler('init', 'system', 'sharemaps_init');

/**
 * Sharemaps plugin initialization functions.
 */
function sharemaps_init() {

    // register a library of helper functions
    elgg_register_library('elgg:sharemaps', elgg_get_plugins_path() . 'sharemaps/lib/sharemaps.php');

    // register geoPHP library
    elgg_register_library('elgg:sharemapsgeophp', elgg_get_plugins_path() . 'sharemaps/lib/geoPHP.inc');

    // Site navigation
    $item = new ElggMenuItem('sharemaps', elgg_echo('sharemaps:menu'), 'sharemaps/all');
    elgg_register_menu_item('site', $item); 

    // Extend CSS
    elgg_extend_view('css/elgg', 'sharemaps/css');

    // add enclosure to rss item
    elgg_extend_view('extensions/item', 'sharemaps/enclosure');

    // register extra css files
    $css_url = '//code.google.com/apis/maps/documentation/javascript/examples/default.css';
    elgg_register_css('kmlcss', $css_url);

    // register extra js files
    $mapkey = trim(elgg_get_plugin_setting('google_api_key', 'sharemaps'));
    elgg_register_js('gkml', '//maps.googleapis.com/maps/api/js?sensor=false&amp;key=' . $mapkey);
    elgg_register_js('kml', '/mod/sharemaps/assets/kml.js');

    // extend group main page
    elgg_extend_view('groups/tool_latest', 'sharemaps/group_module');

    // add the group maps tool option
    add_group_tool_option('sharemaps', elgg_echo('groups:enablemaps'), true);        

    // Register a page handler, so we can have nice URLs
    elgg_register_page_handler('sharemaps', 'sharemaps_page_handler');
	
    // Add a new map widget
    //elgg_register_widget_type('sharemaps', elgg_echo("sharemaps"), elgg_echo("sharemaps:widget:description"));
    elgg_register_widget_type('sharemaps', elgg_echo("sharemaps"), elgg_echo("sharemaps:widget:description"), 'profile,groups');

    // Register URL handlers for maps
    elgg_register_entity_url_handler('object', 'sharemaps', 'sharemaps_url_override');
    //elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'sharemaps_icon_url_override');

    // Register granular notification for this object type
    register_notification_object('object', 'sharemaps', elgg_echo('sharemaps:newupload'));

    // Listen to notification events and supply a more useful message
    elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'sharemaps_notify_message');

    // Register entity type for search
    elgg_register_entity_type('object', 'sharemaps');

    // add a map link to owner blocks
    elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'sharemaps_owner_block_menu');
    
	// register plugin hook for overriding walled garden sites when viewing a map
	elgg_register_plugin_hook_handler("public_pages", "walled_garden", "sharemaps_walled_garden_hook");    

    // Register actions
    $action_path = elgg_get_plugins_path() . 'sharemaps/actions/sharemaps';
    elgg_register_action("sharemaps/upload", "$action_path/upload.php");
    elgg_register_action("sharemaps/delete", "$action_path/delete.php");
    elgg_register_action("sharemaps/download", "$action_path/download.php");
    elgg_register_action("sharemaps/embed", "$action_path/addembed.php");
    // obs elgg_register_action("sharemaps/filepath", "$action_path/filepath.php");

    // embed support
    $item = ElggMenuItem::factory(array(
            'name' => 'sharemaps',
            'text' => elgg_echo('sharemaps'),
            'priority' => 10,
            'data' => array(
                    'options' => array(
                            'type' => 'object',
                            'subtype' => 'sharemaps',
                    ),
            ),
    ));
    elgg_register_menu_item('embed', $item);

    $item = ElggMenuItem::factory(array(
            'name' => 'sharemaps_upload',
            'text' => elgg_echo('sharemaps:upload'),
            'priority' => 100,
            'data' => array(
                    'view' => 'embed/sharemaps_upload/content',
            ),
    ));
    elgg_register_menu_item('embed', $item);

}

/**
 * Allow users to view maps even in walled garden
 *
 * @param string $hook
 * @param string $type
 * @param array $return_value
 * @param array $params
 * @return array
 */
function sharemaps_walled_garden_hook($hook, $type, $return_value, $params){
	$add = array();
	$add[] = 'sharemaps/filepath/.*';
	
	return $add;
}

/**
 *  Dispatches sharemaps pages.
 *  URLs take the form of
 *  All maps:        sharemaps/all
 *  User's maps:    sharemaps/owner/<username>
 *  Friends' maps:  sharemaps/friends/<username>
 *  View maps:       sharemaps/view/<guid>/<title>
 *  New maps:        sharemaps/add/<guid>
 *  Edit maps:       sharemaps/edit/<guid>
 *  Group maps:     sharemaps/group/<guid>/all
 *  Download:        sharemaps/download/<guid>
 *
 * Title is ignored
 *
 * @param array $page
 * @return bool
 */

function sharemaps_page_handler($page) {

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$file_dir = elgg_get_plugins_path() . 'sharemaps/pages/sharemaps';

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			include "$file_dir/owner.php";
			break;
		case 'friends':
			include "$file_dir/friends.php";
			break;
		case 'view':
		case 'read': // Elgg 1.7 compatibility
			set_input('guid', $page[1]);
			include "$file_dir/view.php";
			break;
		case 'add':
			include "$file_dir/upload.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$file_dir/edit.php";
			break;
		case 'search':
			include "$file_dir/search.php";
			break;
		case 'group':
			include "$file_dir/owner.php";
			break;
		case 'all':
			include "$file_dir/world.php";
			break;
		case 'download':
			set_input('guid', $page[1]);
			include "$file_dir/download.php";
			break;
		case 'addembed':
			elgg_set_page_owner_guid($page[1]);
			include "$file_dir/addembed.php";
			break; 
		case 'filepath':
			set_input('guid', $page[1]);
			include "$file_dir/filepath.php";
			break;          
		default:
			return false;
	}
	return true;
}


/**
 * Creates the notification message body
 *
 * @param string $hook
 * @param string $entity_type
 * @param string $returnvalue
 * @param array  $params
 */
function sharemaps_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'sharemaps')) {
		$descr = $entity->description;
		$title = $entity->title;
		$owner = $entity->getOwnerEntity();
		return elgg_echo('sharemaps:notification', array(
			$owner->name,
			$title,
			$descr,
			$entity->getURL()
		));
	}
	return null;
}


/**
 * Add a menu item to the user ownerblock
 */
function sharemaps_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
            $url = "sharemaps/owner/{$params['entity']->username}";
            $item = new ElggMenuItem('sharemaps', elgg_echo('sharemaps'), $url);
            $return[] = $item;
	}
        else {
            if ($params['entity']->sharemaps_enable != "no") {
                $url = "sharemaps/group/{$params['entity']->guid}/all";
                $item = new ElggMenuItem('sharemaps', elgg_echo('sharemaps:group'), $url);
                $return[] = $item;
            }
	}

	return $return;
}


/**
 * Returns an overall map type from the mimetype
 *
 * @param string $mimetype The MIME type
 * @return string The overall type
 */

function sharemaps_get_simple_type($mimetype) {
    return "general";
}

// deprecated and will be removed
function get_general_sharemaps_type($mimetype) {
	elgg_deprecated_notice('Use sharemaps_get_simple_type() instead of get_general_sharemaps_type()', 1.8);
	return sharemaps_get_simple_type($mimetype);
}


/**
 * Returns a list of map types
 *
 * @param int       $container_guid The GUID of the container of the maps
 * @param bool      $friends Whether we're looking at the container or the container's friends
 * @return string The typecloud
 */
function sharemaps_get_type_cloud($container_guid = "", $friends = false) {

	$container_guids = $container_guid;

	if ($friends) {
		// tags interface does not support pulling tags on friends' content so
		// we need to grab all friends
		$friend_entities = get_user_friends($container_guid, "", 999999, 0);
		if ($friend_entities) {
			$friend_guids = array();
			foreach ($friend_entities as $friend) {
				$friend_guids[] = $friend->getGUID();
			}
		}
		$container_guids = $friend_guids;
	}

	elgg_register_tag_metadata_name('simpletype');
	$options = array(
		'type' => 'object',
		'subtype' => 'sharemaps',
		'container_guids' => $container_guids,
		'threshold' => 0,
		'limit' => 10,
		'tag_names' => array('simpletype')
	);
	$types = elgg_get_tags($options);

	$params = array(
		'friends' => $friends,
		'types' => $types,
	);

	return elgg_view('sharemaps/typecloud', $params);
}

function get_sharemaptype_cloud($owner_guid = "", $friends = false) {
	elgg_deprecated_notice('Use sharemaps_get_type_cloud instead of get_sharemapstype_cloud', 1.8);
	return sharemaps_get_type_cloud($owner_guid, $friends);
}


/**
 * Populates the ->getUrl() method for maps objects
 *
 * @param ElggEntity $entity Sharemaps entity
 * @return string Map URL
 */
function sharemaps_url_override($entity) {
	$title = $entity->title;
	$title = elgg_get_friendly_title($title);
	return "sharemaps/view/" . $entity->getGUID() . "/" . $title;
}


/**
 * Override the default entity icon for maps
 * Plugins can override or extend the icons using the plugin hook: 'sharemaps:icon:url', 'override'
 * @return string Relative URL
 * (not used after version 1.8.6 and later)
 */
function sharemaps_icon_url_override($hook, $type, $returnvalue, $params) {
	$sharemaps = $params['entity'];
	$size = $params['size'];
	if (elgg_instanceof($sharemaps, 'object', 'sharemaps')) {

		// thumbnails get first priority
		if ($sharemaps->thumbnail) {
			$ts = (int)$sharemaps->icontime;
			return "mod/sharemaps/thumbnail.php?file_guid=$sharemaps->guid&size=$size&icontime=$ts";
		}

		$mapping = array(
			'application/zip' => 'map',	// kmz
			'application/xml' => 'map',   //kml
		);

		$mime = $sharemaps->mimetype;
		if ($mime) {
			$base_type = substr($mime, 0, strpos($mime, '/'));
		} else {
			$mime = 'none';
			$base_type = 'none';
		}

		if (isset($mapping[$mime])) {
			$type = $mapping[$mime];
		} elseif (isset($mapping[$base_type])) {
			$type = $mapping[$base_type];
		} else {
			$type = 'gmaplink';
		}

		if ($size == 'large') {
			$ext = '_lrg';
		} else {
			$ext = '';
		}
		
		$url = "mod/sharemaps/graphics/icons/{$type}{$ext}.png";
		$url = elgg_trigger_plugin_hook('sharemaps:icon:url', 'override', $params, $url);
		return $url;
	}
}

