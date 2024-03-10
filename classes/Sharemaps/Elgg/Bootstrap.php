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
				
		// register leaflet js files
		$leafletjs_v = SharemapsOptions::getLeafletJSVersion();
		elgg_define_js('sm_leaflet_js', [
			'src' => "//unpkg.com/leaflet@{$leafletjs_v}/dist/leaflet.js", 
			'integrity' => "sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==", 
			"crossorigin" => "",
			'exports' => 'sm_leaflet_js',
		]);
		elgg_register_external_file('css', 'sharemaps_leaflet_css', "//unpkg.com/leaflet@{$leafletjs_v}/dist/leaflet.css");

		// leaflet gpx library
		elgg_define_js('sm_leaflet_gpx', [
			'src' => "//cdnjs.cloudflare.com/ajax/libs/leaflet-gpx/1.7.0/gpx.min.js", 
			'deps' => ['sm_leaflet_js'],
			'exports' => 'sm_leaflet_gpx',
		]);

		// leaflet kml library
		elgg_define_js('sm_leaflet_kml', [
			'deps' => ['sm_leaflet_js'],
			'exports' => 'sm_leaflet_kml',
		]);

		// leaflet geosearch library
		elgg_define_js('sm_leaflet_geosearch', [
			'src' => "//unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js", 
			'deps' => ['sm_leaflet_js'],
			'exports' => 'sm_leaflet_geosearch',
		]);

		// leaflet GoogleMutant library
		elgg_define_js('sm_leaflet_googlemutant', [
			'src' => "//unpkg.com/leaflet.gridlayer.googlemutant@latest/dist/Leaflet.GoogleMutant.js", 
			'deps' => ['sm_leaflet_js'],
			'exports' => 'sm_leaflet_googlemutant',
		]);

		if (SharemapsOptions::isGoogleAPIEnabled()) {
			// Google API library
			$google_maps_api_key = SharemapsOptions::getGoogleAPIKey();
			elgg_define_js('google_maps_api', [
				'src' => "//maps.googleapis.com/maps/api/js?loading=async&libraries=places&key={$google_maps_api_key}",
				'exports' => 'google_maps_api',
			]);
			
			// Leaflet autocomplete library
			elgg_define_js('sm_leaflet_autocomplete', [
				'deps' => ['sm_leaflet_js', 'google_maps_api'],
				'exports' => 'sm_leaflet_autocomplete',
			]);
			elgg_register_external_file('css', 'sm_leaflet_autocomplete_css', elgg_get_simplecache_url('sm_leaflet_autocomplete.css'));

			// leaflet GoogleMutant library / Google layers
			elgg_define_js('sm_leaflet_googlemutant', [
				'src' => "//unpkg.com/leaflet.gridlayer.googlemutant@latest/dist/Leaflet.GoogleMutant.js", 
				'deps' => ['sm_leaflet_js', 'google_maps_api'],
				'exports' => 'sm_leaflet_googlemutant',
			]); 
		}

		// Leaflet Draw plugin
		$leaflet_draw_v = SharemapsOptions::getLeafletDrawVersion();
		elgg_define_js('sm_leaflet_draw', [
			'deps' => ['sm_leaflet_js'],
			'src' => "//cdnjs.cloudflare.com/ajax/libs/leaflet.draw/{$leaflet_draw_v}/leaflet.draw-src.js",
			'exports' => 'sm_leaflet_draw',
		]);
		elgg_register_external_file('css', 'sharemaps_leaflet_draw_css', "//cdnjs.cloudflare.com/ajax/libs/leaflet.draw/{$leaflet_draw_v}/leaflet.draw.css");
		// elgg_require_css("sharemaps_leaflet_draw_css", "//cdnjs.cloudflare.com/ajax/libs/leaflet.draw/{$leaflet_draw_v}/leaflet.draw.css");

		// fullscreen control 
		elgg_define_js('sm_leaflet_fullscreen', [
			'deps' => ['sm_leaflet_js'],
			'src' => "//api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js",
			'exports' => 'sm_leaflet_fullscreen',
		]);
		elgg_register_external_file('css', 'sharemaps_leaflet_fullscreen_css', "//api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css");

		// dropzone.js library
		elgg_define_js('sm_dropzone', [
			'deps' => [],
			'exports' => 'sm_dropzone',
		]);

		// register settings js
		elgg_register_simplecache_view('sharemaps/settings.js');

		// Site navigation
		elgg_register_menu_item('site', [
			'name' => 'sharemaps',
			'icon' => 'newspaper',
			'text' => elgg_echo('sharemaps:menu'),
			'href' => elgg_generate_url('default:object:sharemaps'),
		]);
		
		// Groups
		elgg()->group_tools->register('sharemaps');

	}
}
