<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

$subtypes = array(
    'drawmap' => 'Drawmap',
    'drawmapobject' => 'DrawmapObject',
    'sharemaps' => 'SharemapsPluginMap',
);

foreach ($subtypes as $subtype => $class) {
    if (!update_subtype('object', $subtype, $class)) {
        add_subtype('object', $subtype, $class);
    }
}
