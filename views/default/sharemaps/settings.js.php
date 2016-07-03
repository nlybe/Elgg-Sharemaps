<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

elgg_load_library('elgg:sharemaps');
//$map_settings = elgg_get_plugin_from_id(SHAREMAPS_PLUGIN_ID)->getAllSettings();

$settings = [
    'sm_default_coords' => sharemaps_get_map_default_location_coords(),
];

?>

define(<?php echo json_encode($settings); ?>);
