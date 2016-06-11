<?php
/**
 * Elgg Sharemaps Plugin
 * @package sharemaps 
 */

elgg_require_js('sharemaps/sharemaps');

$entity = $vars['entity'];    
$map_url = elgg_normalize_url('sharemaps/filepath/'.$entity->guid.'?t='.time());

$map_width = $vars['map_width'];
$map_height = $vars['map_height'];

echo elgg_format_element('div', ['id' => 'map', 'style' => "width:{$map_width}; height:{$map_height}; border:3px solid #eee;"], '');
echo elgg_format_element('span', ['id' => 'map_guid', 'style' => 'display:none;'], $entity->getGUID());
echo elgg_format_element('span', ['id' => 'map_url', 'style' => 'display:none;'], $map_url);







