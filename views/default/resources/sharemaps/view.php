<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

elgg_load_library('elgg:sharemaps');

// Get the guid
$entity_guid = elgg_extract('guid', $vars, '');

// Get the file
$sharemaps = get_entity($entity_guid);
if (!$sharemaps) {
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	forward('');
}

if (elgg_instanceof($sharemaps, 'object', 'drawmap')) {
	$sharemaps = new Drawmap($entity_guid);
}
else {
	$sharemaps = new SharemapsPluginMap($entity_guid);
}

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
$content .= elgg_view_comments($sharemaps);

if(!empty($sharemaps->originalfilename)) {  // add download button only for files
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
