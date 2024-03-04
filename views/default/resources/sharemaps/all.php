<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

use Sharemaps\SharemapsOptions;

// elgg_push_breadcrumb(elgg_echo('sharemaps'));
elgg_push_collection_breadcrumbs('object', 'sharemaps');

elgg_register_title_button('sharemaps', 'add', 'object', 'sharemaps');

$title = elgg_echo('sharemaps:all');

$content = elgg_view('sharemaps/listing/all', $vars);

$sidebar = elgg_view('sharemaps/sidebar');

$body = elgg_view_layout('content', array(
    'filter_id' => 'filter',
	'filter_value' => 'all',
    'content' => $content,
    'title' => $title,
    'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
