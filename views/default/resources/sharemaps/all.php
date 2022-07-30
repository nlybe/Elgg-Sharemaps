<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

use Sharemaps\SharemapsOptions;

elgg_push_breadcrumb(elgg_echo('sharemaps'));

// register post buttons
SharemapsOptions::getPostButtons();

$title = elgg_echo('sharemaps:all');

$content = elgg_view('sharemaps/listing/all', $vars);

$sidebar = elgg_view('sharemaps/sidebar');

$body = elgg_view_layout('content', array(
    'filter_context' => 'all',
    'content' => $content,
    'title' => $title,
    'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
