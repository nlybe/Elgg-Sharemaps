<?php
/**
 * Edit a map
 *
 * @package ElggShareMaps
 */

elgg_load_library('elgg:sharemaps');

gatekeeper();

$file_guid = elgg_extract('guid', $vars, '');

$sharemaps = new SharemapsPluginMap($file_guid);
if (!$sharemaps) {
	forward();
}
if (!$sharemaps->canEdit()) {
	forward();
}

$title = elgg_echo('sharemaps:edit');

elgg_push_breadcrumb(elgg_echo('sharemaps'), "sharemaps/all");
elgg_push_breadcrumb($sharemaps->title, $sharemaps->getURL());
elgg_push_breadcrumb($title);

elgg_set_page_owner_guid($sharemaps->getContainerGUID());

$form_vars = array('enctype' => 'multipart/form-data');

$fname = $sharemaps->getFilename();
if(empty($fname)) {
    $gmap = new ElggObject($file_guid);
    
    if ($gmap)    {   
        $body_vars = sharemaps_prepare_form_vars_gmaplink($gmap);
        //$body_vars = sharemaps_prepare_form_vars($gmap);
        $content = elgg_view_form('sharemaps/embed', $form_vars, $body_vars);
        //$content = elgg_view_form('sharemaps/upload', $form_vars, $body_vars);
    }
}
else {
    $body_vars = sharemaps_prepare_form_vars($sharemaps);
    $content = elgg_view_form('sharemaps/upload', $form_vars, $body_vars);
}

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
