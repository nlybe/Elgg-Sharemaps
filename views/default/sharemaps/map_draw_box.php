<?php
/**
 * Elgg Sharemaps Plugin
 * @package sharemaps 
 */

elgg_require_js('sharemaps/drawonmaps');

$entity = $vars['entity'];    

$map_width = $vars['map_width'];
$map_height = $vars['map_height'];

if ($entity) { 
    echo elgg_format_element('span', ['id' => 'map_guid', 'style' => 'display:none;'], $entity->getGUID());
}
echo elgg_format_element('span', ['id' => 'map_objects'], '');
?>
		
<div class="row">
    <div class="popin">
        <?php echo elgg_format_element('div', ['id' => 'map', 'style' => "width:{$map_width}; height:{$map_height}; border:3px solid #eee;"], ''); ?>
    </div>
</div>







