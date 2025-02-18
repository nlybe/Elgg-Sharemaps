<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

use Elgg\Exceptions\Http\EntityNotFoundException;

$username = elgg_extract('username', $vars);

$user = get_user_by_username($username);
if (!$user) {
	throw new EntityNotFoundException();
}

elgg_push_breadcrumb(elgg_echo('sharemaps'), elgg_generate_url('default:object:sharemaps'));
elgg_push_collection_breadcrumbs('object', 'sharemaps', $user);

elgg_register_title_button('add', 'object', 'sharemaps');

$vars['entity'] = $user;
$title = elgg_echo('collection:object:sharemaps');
echo elgg_view_page($title, [
	'filter_value' => $user->guid == elgg_get_logged_in_user_guid() ? 'mine' : 'none',
	'content' => elgg_view('sharemaps/listing/owner', $vars),
	'title' => $title,
	'sidebar' => elgg_view('sharemaps/sidebar', $vars),
]);