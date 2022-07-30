<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

use Sharemaps\SharemapsOptions;

$title = elgg_echo('sharemaps:add');

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid);

$page_owner = get_entity($guid);

if (!$page_owner->canWriteToContainer(0, 'object', 'sharemaps')) {
	throw new \Elgg\EntityPermissionsException();
}

elgg_push_breadcrumb(elgg_echo('sharemaps'), 'maps');
elgg_push_collection_breadcrumbs('object', 'sharemaps', $page_owner);
elgg_push_breadcrumb($title);

$body_vars = SharemapsOptions::sharemaps_prepare_form_vars();
$content = elgg_view_form('sharemaps/edit', [
	'enctype' => 'multipart/form-data',
	'action' => 'action/sharemaps/save'
], $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
