<?php
/**
 * Elgg map upload/save form
 *
 * @package ElggShareMaps
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use 
$gmaplink = elgg_extract('gmaplink', $vars, '');
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
if (!$container_guid) {
	$container_guid = elgg_get_logged_in_user_guid();
}
$guid = elgg_extract('guid', $vars, null);

if ($guid) {
	$file_label = elgg_echo("sharemaps:replace");
	$submit_label = elgg_echo('save');
} else {
	$file_label = elgg_echo("sharemaps:file");
	$submit_label = elgg_echo('upload');
}

?>
<div>
	<label><?php echo elgg_echo('sharemaps:gmaplink'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'gmaplink', 'value' => $gmaplink)); ?>
        <div class="elgg-subtext">
            <a href="#" class="tooltip"><?php echo elgg_echo("sharemaps:gmaplinkhowto");?>
                <span><img src="<?php echo elgg_get_site_url().'mod/sharemaps/graphics/gmaplinksample.png';?>" style="float:right;" alt="Google map link sample"></span>
            </a>
        </div>
</div>

<div>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>
<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'file_guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => $submit_label));

?>
</div>
