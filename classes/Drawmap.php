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
    
    // get the objects/shapes of the map
    public function getMapObjects() {
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
