<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

class Drawmap extends ElggObject {
    const SUBTYPE = "drawmap";
    
    protected $meta_defaults = array(
        "title" 		=> NULL,
        "description" 	=> NULL,
        "dm_markers" 	=> NULL,
        "tags"          => NULL,
        "comments_on"	=> NULL,
    );    

    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes["subtype"] = self::SUBTYPE;
    }
    
	public function __construct($guid = null) {
		if ($guid && !is_object($guid)) {
			// Loading entities via __construct(GUID) is deprecated, so we give it the entity row and the
			// attribute loader will finish the job. This is necessary due to not using a custom
			// subtype (see above).
			$guid = get_entity_as_row($guid);
		}		
		
		parent::__construct($guid);
	}
	    
    // get the objects/shapes of the map
    public function getMapObjects($simplified_list = false) {
        $map_objects = array();
        $options = array(
            'type' => 'object',
            'subtype' => 'drawmapobject',
            'limit' => 0,
            'full_view' => false,
            'view_toggle_type' => false,
            'metadata_name_value_pairs' => array(
                array('name' => 'map_guid', 'value' => $this->guid, 'operand' => '='), 
            )
        );

        $entities = elgg_get_entities_from_metadata($options);		
        if ($entities) {
            if ($simplified_list) {
                foreach($entities as $e) {
                    $map_objects_x = array();
                    $map_objects_x['guid'] = $e->getGUID();
                    $map_objects_x['title'] = $e->title;
                    $map_objects_x['coords'] = $e->coords;
                    $map_objects_x['object_id'] = $e->object_id;
                    array_push($map_objects, $map_objects_x);
                }
            }
            else {
                $map_objects = $entities;
            }
        }
        
        return $map_objects;
    }  
    
    // delete objects/shapes of the map, return true if we have even one deletion at least
    public function deleteMapObjects() {
		$daction = false;
		$options = array(
			'type' => 'object',
			'subtype' => 'drawmapobject',
			'limit' => 0,
			'full_view' => false,
			'view_toggle_type' => false,
			'metadata_name_value_pairs' => array(
				array('name' => 'map_guid', 'value' => $this->guid, 'operand' => '='), 
			)
		);
		
		$map_objects = elgg_get_entities_from_metadata($options);	
		
		if ($map_objects) 	{
			foreach ($map_objects as $mo)	{
				if ($mo->delete())	
					$daction = true;	
			}
		}
		
		return $map_objects;
    }  
    
}
