<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$object = $item->getObjectEntity();
$vars['message'] = $object->description? elgg_get_excerpt($object->description) : '';
$vars['attachments'] = elgg_view('output/url', ['href' => $object->address]);

echo elgg_view('river/elements/layout', $vars);
