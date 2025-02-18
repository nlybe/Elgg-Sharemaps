<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

use Sharemaps\Elgg\Bootstrap;

require_once(dirname(__FILE__) . "/lib/events.php");

return [
    'plugin' => [
        'name' => 'ShareMaps',
		'version' => '5.14',
		'dependencies' => [],
	],
	'bootstrap' => Bootstrap::class,
	'entities' => [
		[
            'type' => 'object',
            'subtype' => 'sharemaps',
            'class' => '\ElggMap',
            'capabilities' => [
				'commentable' => true,
				'searchable' => true,
				'likable' => true,
			],
        ],
    ],
	'settings' => [
		'google_maps_api' => 'no',
		'leafletjs_version' => '1.9.4',
		'params[map_height]' => 500,
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
	'events' => [
		'register' => [
			'menu:owner_block' => [
				'sharemaps_owner_block_menu' => []
			],
		],
	],
	'widgets' => [
		'sharemaps' => [
			'context' => ['profile', 'dashboard'],
		],
	],
    'views' => [
        'default' => [
			'sharemaps/icons/' => __DIR__ . '/graphics',
			'sm_leaflet_kml.js' => __DIR__ . '/vendors/leaflet_plugins/leaflet.kml.js',
			'sm_leaflet_autocomplete.js' => __DIR__ . '/vendors/leaflet_plugins/leaflet-gplaces-autocomplete.js',
			'sm_leaflet_autocomplete.css' => __DIR__ . '/vendors/leaflet_plugins/leaflet-gplaces-autocomplete.css',
			'sm_dropzone.js' => __DIR__ . '/vendors/js/dropzone.js',
        ],
    ],
	'view_extensions' => [
		'elgg.css' => [
			'sharemaps/sharemaps.css' => [],
		],
	],
	'upgrades' => [],
];

