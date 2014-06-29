<?php
/**
 * View a map
<<<<<<< HEAD
 * @package ElggShareMaps
 */

// include gpx libraries
// elgg_load_library('elgg:sharemapsgeophp');

=======
 *
 * @package ElggShareMaps
 */

>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
// Get the guid
$file_guid = (int) get_input('guid');

// Get the file
$sharemaps = get_entity($file_guid);
if (!$sharemaps) {
<<<<<<< HEAD
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	forward('');
=======
        register_error(elgg_echo('noaccess'));
        $_SESSION['last_forward_from'] = current_page_url();
        forward('');
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
}

$sharemaps = new SharemapsPluginMap($file_guid);

global $CONFIG;
if (!isset($CONFIG)) {
	$CONFIG = new stdClass;
}

<<<<<<< HEAD
=======
$filename = $sharemaps->originalfilename;
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
$owner = elgg_get_page_owner_entity();
elgg_push_breadcrumb(elgg_echo('sharemaps'), 'sharemaps/all');

$crumbs_title = $owner->name;
if (elgg_instanceof($owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "sharemaps/group/$owner->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, "sharemaps/owner/$owner->username");
}
$title = $sharemaps->title;
elgg_push_breadcrumb($title);

$content = elgg_view_entity($sharemaps, array('full_view' => true)); 
<<<<<<< HEAD
$content .= elgg_view_comments($sharemaps);

if(!empty($sharemaps->originalfilename)) {  // add download button only for files
=======

//Read map width and height from settings
$mapwidth = trim(elgg_get_plugin_setting('map_width', 'sharemaps'));
if (strripos($mapwidth, '%') === false) {
    if (is_numeric($mapwidth))  $mapwidth = $mapwidth.'px';
    else $mapwidth = '100%';
} 

$mapheight = trim(elgg_get_plugin_setting('map_height', 'sharemaps'));
if (strripos($mapheight, '%') === false) {
    if (is_numeric($mapheight))  $mapheight = $mapheight.'px';
    else $mapheight = '500px';
} 

if(empty($filename)) {  // gmap link
   if(!empty($sharemaps->gmaplink)) {
       //$content .= $sharemaps->gmaplink;
       $content .= '<br />';
       $content .= '<div>';
       $content .= '<iframe style="border:1px solid #eee;" width="'.$mapwidth.'" height="'.$mapheight.'" scrolling="no" marginheight="0" marginwidth="0" src="'.$sharemaps->gmaplink.'&amp;output=embed"></iframe>';
       $content .= '</div>';
   }
}
else {  // kml file

    $mapfile = $sharemaps->getFilenameOnFilestore();
    
    // check if kml file
    $pos = strripos($mapfile, '.kml');
    
    // check if kmz file
    if ($pos === false) {
            $pos = strripos($mapfile, '.kmz');
    }  

    if ($pos != false) {
        elgg_load_css('kmlcss');
        elgg_load_js('gkml');
        elgg_load_js('kml');

        //add time parameter to load kml map
        date_default_timezone_set('UTC');
        
        // assign maps folder location elgg_get_plugins_path()
        $mapspath = elgg_get_plugins_path().'sharemaps/maps/';
        // remove files older than 15 minutes
        $files = glob($mapspath.'*'); // get all file names
        foreach($files as $file){ // iterate files
                if(is_file($file))	{
                        $ttt = (time() - filemtime($file));
                        if ($ttt > 900)	{
                                unlink($file);
                        }
                }
        } 
        
        // create new kml file with random filename
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
        $my_file = $randomString.'.kml';
        $handle = fopen($mapspath.$my_file, 'w') or die('Cannot open kml file. Make sure that folder mod/sharemaps/maps is writable from web server');
        
        // write entity kml content to file
        fwrite($handle, file_get_contents($mapfile));
        fclose($handle);
        $kmlurl = elgg_get_site_url().'mod/sharemaps/maps/'.$my_file.'?t='.time();
        $content .= '<script language="javascript" type="text/javascript">';
        $content .= 'window.onload = function () {';
        $content .= 'initialize(encodeURI("'.$kmlurl.'"));';
        $content .= '}';
        $content .= '</script>';
        $content .= '<br />';
        $content .= '<div id="map_canvas" style="width:'.$mapwidth.'; height:'.$mapheight.'; border:1px solid #eee; "></div>';
       
    }    
    
}

$content .= elgg_view_comments($sharemaps);

if(!empty($filename)) {  // add download button only for files
>>>>>>> 0d462235f8f2813afc8e0ce8d5d06e2fa0e2d1ee
    elgg_register_menu_item('title', array(
            'name' => 'download',
            'text' => elgg_echo('sharemaps:download'),
            'href' => "sharemaps/download/$sharemaps->guid",
            'link_class' => 'elgg-button elgg-button-action',
    ));
}

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
