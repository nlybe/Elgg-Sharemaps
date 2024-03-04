<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

$title = elgg_extract('title', $vars, '');
$description = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
if (!$container_guid) {
	$container_guid = elgg_get_logged_in_user_guid();
}
$guid = elgg_extract('guid', $vars, null);

echo elgg_format_element('p', [], elgg_echo('sharemaps:add:requiredfields'));

echo elgg_view_field([
    '#type' => 'text',
    'name' => 'title',
    'value' => $title,
    '#label' => elgg_echo('title'),
    '#help' => elgg_echo('sharemaps:add:title:help'),
    'required' => true,
]);

echo elgg_view_field([
    '#type' => 'mapdraw',
    'name' => 'mapdraw',
    '#label' => elgg_echo('sharemaps:add:smap'),
    '#help' => elgg_echo('sharemaps:add:smap:help'),
    'entity' => elgg_extract('entity', $vars, null),
]);

echo elgg_view_field([
    '#type' => 'longtext',
    'name' => 'description',
    'value' => $description,
    '#label' => elgg_echo('description'),
    '#help' => elgg_echo('sharemaps:add:description:help'),
]);

echo elgg_view_field([
    '#type' => 'tags',
    'name' => 'tags',
    'value' => $tags,
    '#label' => elgg_echo('tags'),
    '#help' => elgg_echo('sharemaps:add:tags:help'),
]);

echo elgg_view_field([
    '#type' => 'access',
    'name' => 'access_id',
    'value' => $access_id,
    '#label' => elgg_echo('access'),
]);

echo elgg_view_field([
    '#type' => 'dropdown',
    'id' => 'sharemaps_comments_on',
    'name' => 'comments_on',
    'value' => elgg_extract('comments_on', $vars, ''),
    'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off')),
    '#label' => elgg_echo('comments'),
]);

?>

<div class="elgg-foot">
<?php

    if ($guid) {
        echo elgg_view_field([
            'id' => 'guid',
            '#type' => 'hidden',
            'name' => 'file_guid',
            'value' => $guid,
        ]);        
    }

    echo elgg_view_field([
        '#type' => 'hidden',
        'name' => 'container_guid',
        'value' => $container_guid,
    ]);

    echo elgg_view_field([
        '#type' => 'submit',
        'value' => elgg_echo('save')
    ]);   
?>
</div>

