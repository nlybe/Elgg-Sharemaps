<?php
/**
 * Elgg sharemaps plugin language pack
 *
 * @package ElggShareMaps
 */

$spanish = array(

    //Menu items and titles
    'sharemaps' => "Mapas",
    'sharemaps:menu' => "Rutas - Mapas",
    'sharemaps:user' => "Tus mapas",
    'sharemaps:friends' => "Mapas de Amigos",
    'sharemaps:all' => "Todos los mapas",
    'sharemaps:edit' => "Editar mapa",
    'sharemaps:more' => "Mas mapas",
    'sharemaps:list' => "ver listado",
    'sharemaps:group' => "Mapas del Grupo",
    'sharemaps:gallery' => "ver galería",
    'sharemaps:gallery_list' => "Galería o listado",
    'sharemaps:num_files' => "Numero de mapas a mostrar",
    'sharemaps:user:gallery'=>'Ver %s galería',
    'sharemaps:upload' => "Subir mapa",
    'sharemaps:replace' => 'Reemplazar contenido del mapa (dejar en blanco para no cambiar el archivo)',
    'sharemaps:list:title' => "%s's %s %s",
    'sharemaps:title:friends' => "Amigos",

    'sharemaps:add' => 'Subir mapa',

    'sharemaps:file' => "Mapa",
    'sharemaps:title' => "Titulo",
    'sharemaps:desc' => "Descripción",
    'sharemaps:tags' => "Tags",

    'sharemaps:list:list' => 'Cambie a la vista de lista',
    'sharemaps:list:gallery' => 'Cambie a la vista de galería',

    'sharemaps:types' => "Subir tipos de archivo",

    'sharemaps:type:' => 'Mapas',
    'sharemaps:type:all' => "Todo el mapa",
    'sharemaps:type:general' => "General",

    'sharemaps:widget' => "Sharemaps widget",
    'sharemaps:widget:description' => "Mostrar mis últimos mapas",

    'groups:enablemaps' => 'Habilitar los mapas de grupo',

    'sharemaps:download' => "Descargar mapa",

    'sharemaps:delete:confirm' => "Está seguro que desea eliminar este mapa?",

    'sharemaps:tagcloud' => "Tag cloud",

    'sharemaps:display:number' => "Numero de mapas a mostrar",

    'river:create:object:sharemaps' => '%s mapa cargado %s',
    'river:comment:object:sharemaps' => '%s comentar mapa %s',
    
    'item:object:sharemaps' => 'Mapas',

    'sharemaps:newupload' => 'Un nuevo mapa se ha añadido',
    'sharemaps:notification' =>
'%s añadido nuevo mapa:

%s
%s

Ver y comentar el nuevo mapa:
%s
',

    //Status messages
    'sharemaps:saved' => "El mapa se ha guardado correctamente.",
    'sharemaps:deleted' => "El mapa se ha borrado correctamente.",

    //Error messages
    'sharemaps:none' => "No hay mapas.",
    'sharemaps:uploadfailed' => " Lamentablemente, no hemos podido guardar el mapa.",
    'sharemaps:downloadfailed' => " Lamentablemente, este mapa no está disponible en este momento.",
    'sharemaps:deletefailed' => "Su mapa no pudo ser eliminado en este momento.",
    'sharemaps:noaccess' => "No tiene permisos para modificar este mapa",
    'sharemaps:cannotload' => "Se ha producido un error al cargar el mapa",
    'sharemaps:nofile' => "Debe seleccionar un archivo de mapa",
    'sharemaps:nokmlfile' => "Tipo de archivo no válido. Tipo de archivo debe ser Google Earth KML o KMZ",
    'sharemaps:noaccesstofilemap' => "No hay acceso al archivo de mapa",

    // settings
    'sharemaps:settings:google_maps' => 'Ajustes de Google Maps',
    'sharemaps:settings:google_api_key' => 'Escribe aquí tu Google API key',
    'sharemaps:settings:google_api_key:help' => 'ir a <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key">https://developers.google.com/maps/documentation/javascript/tutorial#api_key</a> para conseguir tu "Google API key". <br />(<strong>Note:</strong> la API key NO ES NECESARIA. Sólo si quieres estadísticas sobre su uso de la API, o si usted tiene una cuenta de API key de pago, entonces la clave si se necesita)',
    'sharemaps:settings:map_width' => 'Ancho del mapa',
    'sharemaps:settings:map_width:help' => 'Valor numérico (ej. 500) o % (ej. 100%)',
    'sharemaps:settings:map_height' => 'Alto del mapa',
    'sharemaps:settings:map_height:help' => 'Valor numérico (ej. 500)',
    
    // embed maps
    'sharemaps:embed' => 'Insertar link de google maps',
    'sharemaps:addembed' => 'Insertar link de google maps',
    'sharemaps:gmaplink' => 'Link google maps',
    'sharemaps:gmaplinkhowto' => 'Copia la URL de tu mapa o ruta en googlemaps y pegarla aquí (NO URL Corta)',
    'sharemaps:gmaphowtouploadkml' => 'El tipo de archivo debe ser Google Earth, KML o KMZ. Usted puede convertir su archivo .gpx en <a href="http://gpx2kml.com" target="_blank" title="Convierta el archivo gpx a kml">http://gpx2kml.com</a>.',

);

add_translation("es", $spanish);
