<?php
/**
 * Elgg map browser download action.
 *
 * @package ElggShareMaps
 */

// @todo this is here for backwards compatibility (first version of embed plugin?)
$download_page_handler = elgg_get_plugins_path() . 'sharemaps/download.php';

include $download_page_handler;
