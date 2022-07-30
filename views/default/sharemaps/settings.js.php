<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

use Sharemaps\SharemapsOptions;

$settings = [
    'google_maps_api' => SharemapsOptions::isGoogleAPIEnabled(),
    'google_maps_api_key' => SharemapsOptions::getGoogleAPIKey(),
    'leafletjs_toolbox_enabled' => SharemapsOptions::isLeafletJSToolboxEnabled(),
];

?>

define(<?php echo json_encode($settings); ?>);
