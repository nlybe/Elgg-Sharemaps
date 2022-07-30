<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

use Sharemaps\Elgg\Bootstrap;

require_once(dirname(__FILE__) . "/lib/hooks.php");

return [
	'bootstrap' => Bootstrap::class,
	'entities' => [
		[
            'type' => 'object',
            'subtype' => 'sharemaps',
            'class' => '\ElggMap',
            'searchable' => true,
        ],
    ],
	'settings' => [
		'google_maps_api' => 'no',
		'leafletjs_version' => '1.7.1',
		'leaflet_draw_version' => '1.0.4',
		'map_location' => 'before',
		'leafletjs_toolbox_enable' => 'no',
    ],
    'actions' => [
		'sharemaps/save' => [],
		'sharemaps/upload' => [],
    ],
	'routes' => [
        'default:object:sharemaps' => [
			'path' => '/maps',
			'resource' => 'sharemaps/all',
		],
		'collection:object:sharemaps:all' => [
			'path' => '/maps/all',
			'resource' => 'sharemaps/all',
        ],  
        'collection:object:sharemaps:owner' => [
			'path' => '/maps/owner/{username?}',
			'resource' => 'sharemaps/owner',
		],
		'collection:object:sharemaps:friends' => [
			'path' => '/maps/friends/{username}',
			'resource' => 'sharemaps/friends',
		],		
		'collection:object:sharemaps:group' => [
			'path' => '/maps/group/{guid?}',
			'resource' => 'sharemaps/group',
		],	
		'add:object:sharemaps' => [
			'path' => '/maps/add/{guid?}',
			'resource' => 'sharemaps/add',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'edit:object:sharemaps' => [
			'path' => '/maps/edit/{guid}',
			'resource' => 'sharemaps/edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'view:object:sharemaps' => [
			'path' => '/maps/view/{guid}/{title?}',
			'resource' => 'sharemaps/view',
		],
		'view:object:sharemaps:filepath' => [
			'path' => '/maps/filepath/{guid}',
			'resource' => 'sharemaps/filepath',
		],
    ],
	'widgets' => [
		'sharemaps' => [
			'context' => ['profile', 'dashboard'],
		],
	],
    'views' => [
        'default' => [
			'maps/edit/' => __DIR__ . '/graphics',
			// 'sharemaps/graphics/' => __DIR__ . '/graphics',
			'sm_leaflet_kml.js' => __DIR__ . '/vendors/leaflet_plugins/leaflet.kml.js',
			// 'sm_leaflet_kml.js' => __DIR__ . '/vendors/leaflet_plugins/leaflet-omnivore.min.js',			
			'sm_leaflet_google_mutant.js' => __DIR__ . '/vendors/leaflet_plugins/Leaflet.GoogleMutant.js',
			'sm_leaflet_autocomplete.js' => __DIR__ . '/vendors/leaflet_plugins/leaflet-gplaces-autocomplete.js',
			'sm_leaflet_autocomplete.css' => __DIR__ . '/vendors/leaflet_plugins/leaflet-gplaces-autocomplete.css',
			'sm_dropzone.js' => __DIR__ . '/vendors/js/dropzone.js',
        ],
    ],
	'upgrades' => [],
];

