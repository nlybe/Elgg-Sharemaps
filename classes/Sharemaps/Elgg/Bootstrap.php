<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

namespace Sharemaps\Elgg;

use Elgg\DefaultPluginBootstrap;
use Sharemaps\SharemapsOptions;

class Bootstrap extends DefaultPluginBootstrap {
	
	const HANDLERS = [];
	
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		$this->initViews();
	}

	/**
	 * Init views
	 *
	 * @return void
	 */
	protected function initViews() {
				
		// Extend CSS
		elgg_extend_view('css/elgg', 'sharemaps/sharemaps.css');
		
		// register leaflet js files
		$leafletjs_v = SharemapsOptions::getLeafletJSVersion();
		elgg_define_js('sm_leaflet_js', array(
			'src' => "//unpkg.com/leaflet@{$leafletjs_v}/dist/leaflet.js", 
			'integrity' => "sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==", 
			"crossorigin" => "",
			'exports' => 'sm_leaflet_js',
		));
		elgg_register_css("sharemaps_leaflet_css", "//unpkg.com/leaflet@{$leafletjs_v}/dist/leaflet.css");

		// leaflet gpx library
		elgg_define_js('sm_leaflet_gpx', array(
			'src' => "//cdnjs.cloudflare.com/ajax/libs/leaflet-gpx/1.4.0/gpx.min.js", 
			'deps' => array('sm_leaflet_js'),
			'exports' => 'sm_leaflet_gpx',
		));

		// leaflet kml library
		elgg_define_js('sm_leaflet_kml', [
			'deps' => ['sm_leaflet_js'],
			'exports' => 'sm_leaflet_kml',
		]);
		elgg_register_css("sharemaps_leaflet_css", "//unpkg.com/leaflet@{$leafletjs_v}/dist/leaflet.css");

		if (SharemapsOptions::isGoogleAPIEnabled()) {
			// Google API library
			$google_maps_api_key = SharemapsOptions::getGoogleAPIKey();
			elgg_define_js('google_maps_api', [
				'src' => "//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={$google_maps_api_key}",
				'exports' => 'google_maps_api',
			]);
			
			// Leaflet autocomplete library
			elgg_define_js('sm_leaflet_autocomplete', [
				'deps' => ['sm_leaflet_js', 'google_maps_api'],
				'exports' => 'sm_leaflet_autocomplete',
			]);
			elgg_register_css('sm_leaflet_autocomplete_css', elgg_get_simplecache_url('sm_leaflet_autocomplete.css'));


			// Google layers
			elgg_define_js('sm_leaflet_google_mutant', [
				'deps' => ['sm_leaflet_js', 'google_maps_api'],
				'exports' => 'sm_leaflet_google_mutant',
			]);        
		}

		// Leaflet Draw plugin
		$leaflet_draw_v = SharemapsOptions::getLeafletDrawVersion();
		elgg_define_js('sm_leaflet_draw', [
			'deps' => ['sm_leaflet_js'],
			'src' => "//cdnjs.cloudflare.com/ajax/libs/leaflet.draw/{$leaflet_draw_v}/leaflet.draw-src.js",
			'exports' => 'sm_leaflet_draw',
		]);
		elgg_register_css("sharemaps_leaflet_draw_css", "//cdnjs.cloudflare.com/ajax/libs/leaflet.draw/{$leaflet_draw_v}/leaflet.draw.css");

		// dropzone.js library
		elgg_define_js('sm_dropzone', [
			'deps' => [],
			'exports' => 'sm_dropzone',
		]);

		// register settings js
		elgg_register_simplecache_view('sharemaps/settings.js');

		// Site navigation
		$item = new \ElggMenuItem('sharemaps', elgg_echo('sharemaps:menu'), 'maps');
		elgg_register_menu_item('site', $item); 

		// Register menu item to an ownerblock. It is used to  register news menu item to groups
		elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'sharemaps_owner_block_menu');

		// Groups
		elgg()->group_tools->register('sharemaps');

		// set type of maps available
		elgg_set_config('sm_post_buttons', array(
			'map_upload' => ['button' => 'add'],
		));		

	}
}
