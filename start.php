<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

elgg_register_event_handler('init', 'system', 'sharemaps_init');

define('SHAREMAPS_PLUGIN_ID', 'sharemaps'); // general purpose string for yes
define('SHAREMAPS_GENERAL_YES', 'yes'); // general purpose string for yes
define('SHAREMAPS_GENERAL_NO', 'no'); // general purpose string for no
define('SHAREMAPS_GENERAL_BEFORE', 'before'); // general purpose string for before
define('SHAREMAPS_GENERAL_AFTER', 'after'); // general purpose string for after
define('SHAREMAPS_MAP_OBJECT_MARKER', 1);  // marker id
define('SHAREMAPS_MAP_OBJECT_POLYLINE', 2);  // polyline id
define('SHAREMAPS_MAP_OBJECT_POLYGON', 3);  // polygon id
define('SHAREMAPS_MAP_OBJECT_RECTANGLE', 4); // rectangle id
define('SHAREMAPS_MAP_OBJECT_CIRCLE', 5);  // circle id
define('SHAREMAPS_DEFAULT_LOCATION_COORDS', '35.516426,24.017444');  // default location coords

/**
 * Sharemaps plugin initialization functions.
 */
function sharemaps_init() {

    // register a library of helper functions
    elgg_register_library('elgg:sharemaps', elgg_get_plugins_path() . 'sharemaps/lib/sharemaps.php');

    // register geoPHP library
    elgg_register_library('elgg:sharemaps_geophp', elgg_get_plugins_path() . 'sharemaps/lib/geoPHP.inc');

    // Site navigation
    $item = new ElggMenuItem('sharemaps', elgg_echo('sharemaps:menu'), 'sharemaps/all');
    elgg_register_menu_item('site', $item);

    // add enclosure to rss item
    elgg_extend_view('extensions/item', 'sharemaps/enclosure');

    // register extra css files
    elgg_register_css('sharemaps_drawonmaps_css', elgg_get_simplecache_url('sharemaps/drawonmaps.css'));

    // register extra js files
    $mapkey = trim(elgg_get_plugin_setting('google_api_key', SHAREMAPS_PLUGIN_ID));
    elgg_define_js('sharemaps_googleapis_js', array(
        'src' => "//maps.googleapis.com/maps/api/js?key={$mapkey}",
        'exports' => 'sharemaps_googleapis_js',
    ));
    /* Probably OBS
      elgg_define_js('sharemaps_ajaxgoogleapis_js', array(
      'src' => "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js",
      'exports' => 'sharemaps_ajaxgoogleapis_js',
      ));
     * */

    elgg_define_js('sharemaps_gmaps_js', array(
        'exports' => 'sharemaps_gmaps_js',
    ));

    //elgg_define_js('sharemaps_prettify', array(
    //    'deps' => array('jquery', 'sharemaps_prettify_js'),
    //    'exports' => 'sharemaps_prettify',
    //));
    //elgg_define_js('sharemaps_drawonmaps_elgg', array(
    //    'deps' => array('jquery', 'sharemaps_drawonmaps_elgg_js'),
    //    'exports' => 'sharemaps_drawonmaps_elgg',
    //));
    // extend group main page
    elgg_extend_view('groups/tool_latest', 'sharemaps/group_module');

    // add the group maps tool option
    add_group_tool_option('sharemaps', elgg_echo('groups:enablemaps'), true);

    // Register a page handler, so we can have nice URLs
    elgg_register_page_handler('sharemaps', 'sharemaps_page_handler');

    // Add a new map widget
    elgg_register_widget_type('sharemaps', elgg_echo("sharemaps"), elgg_echo("sharemaps:widget:description"), array('profile', 'groups', 'dashboard'));

    // Register URL handlers for maps
    elgg_register_plugin_hook_handler('entity:url', 'object', 'sharemaps_set_url');

    // Register granular notification for this object type
    elgg_register_notification_event('object', 'sharemaps', array('create'));

    // Listen to notification events and supply a more useful message
    elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'sharemaps_notify_message');

    // Register entities type for search
    elgg_register_entity_type('object', 'sharemaps');
    elgg_register_entity_type('object', 'drawmap');

    // add a map link to owner blocks
    elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'sharemaps_owner_block_menu');

    // register plugin hook for overriding walled garden sites when viewing a map
    elgg_register_plugin_hook_handler("public_pages", "walled_garden", "sharemaps_walled_garden_hook");

    // register plugin settings view
    elgg_register_simplecache_view('sharemaps/settings.js');
    
    // set type of maps available
    elgg_set_config('sm_map_types', array(
        'map_upload' => array('button' => 'add'),
        'map_creation' => array('button' => 'drawmap/add'),
        'gmaps_links' => array('button' => 'addembed'),
    ));

    // Register actions
    $action_path = elgg_get_plugins_path() . 'sharemaps/actions/sharemaps';
    elgg_register_action("sharemaps/upload", "$action_path/upload.php");
    elgg_register_action("sharemaps/delete", "$action_path/delete.php");
    elgg_register_action("sharemaps/download", "$action_path/download.php");
    elgg_register_action("sharemaps/embed", "$action_path/addembed.php");
    elgg_register_action("sharemaps/drawmap", "$action_path/drawmap.php");
    elgg_register_action("sharemaps/drawmap/delete", "$action_path/dm_delete.php");
    elgg_register_action("sharemaps/drawmap/load_objects", "$action_path/dm_load_objects.php");

    /* OBS ????
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
     * 
     */
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
function sharemaps_walled_garden_hook($hook, $type, $return_value, $params) {
    $add = array();
    $add[] = 'sharemaps/filepath/.*';

    return $add;
}

/**
 *  Dispatches sharemaps pages.
 *
 * @param array $page
 * @return bool
 */
function sharemaps_page_handler($page) {

    if (!isset($page[0])) {
        $page[0] = 'all';
    }

    switch ($page[0]) {
        case 'owner':
            echo elgg_view_resource('sharemaps/owner');
            break;
        case 'friends':
            echo elgg_view_resource('sharemaps/friends');
            break;
        case 'view':
            $resource_vars['guid'] = elgg_extract(1, $page);
            echo elgg_view_resource('sharemaps/view', $resource_vars);
            break;
        case 'add':
            echo elgg_view_resource('sharemaps/upload');
            break;
        case 'edit':
            $resource_vars['guid'] = elgg_extract(1, $page);
            echo elgg_view_resource('sharemaps/edit', $resource_vars);
            break;
        case 'group':
            echo elgg_view_resource('sharemaps/owner');
            break;
        case 'all':
            echo elgg_view_resource('sharemaps/world');
            break;
        case 'download':
            $resource_vars['guid'] = elgg_extract(1, $page);
            echo elgg_view_resource('sharemaps/download', $resource_vars);
            break;
        case 'addembed':
            elgg_set_page_owner_guid($page[1]);
            echo elgg_view_resource('sharemaps/addembed');
            break;
        case 'drawmap':
            switch ($page[1]) {
                case 'edit':
                    $resource_vars['guid'] = elgg_extract(2, $page);
                    echo elgg_view_resource('sharemaps/dm_edit', $resource_vars);
                    break;
                case 'add':
                    elgg_set_page_owner_guid($page[2]);
                    echo elgg_view_resource('sharemaps/drawmap');
                    break;
            }
            break;
        case 'filepath':
            $resource_vars['guid'] = elgg_extract(1, $page);
            echo elgg_view_resource('sharemaps/filepath', $resource_vars);
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
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return \ElggMenuItem
 */
 function sharemaps_owner_block_menu($hook, $type, $return, $params) {
    if (elgg_instanceof($params['entity'], 'user')) {
        $url = "sharemaps/owner/{$params['entity']->username}";
        $item = new ElggMenuItem('sharemaps', elgg_echo('sharemaps'), $url);
        $return[] = $item;
    } else {
        if ($params['entity']->sharemaps_enable != "no") {
            $url = "sharemaps/group/{$params['entity']->guid}/all";
            $item = new ElggMenuItem('sharemaps', elgg_echo('sharemaps:group'), $url);
            $return[] = $item;
        }
    }

    return $return;
}

/**
 * Format and return the URL for sharemaps objects, since 1.9.
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string URL of map objects.
 */
function sharemaps_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];
    if (elgg_instanceof($entity, 'object', 'sharemaps') || elgg_instanceof($entity, 'object', 'drawmap')) {
        $friendly_title = elgg_get_friendly_title($entity->title);
        return "sharemaps/view/{$entity->guid}/$friendly_title";
    }
}