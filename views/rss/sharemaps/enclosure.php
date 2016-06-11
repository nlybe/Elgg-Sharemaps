<?php
/**
 * Link to download the map
 *
 * @uses $vars['entity']
 */

if (elgg_instanceof($vars['entity'], 'object', 'sharemaps')) {
	$download_url = elgg_get_site_url() . 'sharemaps/download/' . $vars['entity']->getGUID();
}
