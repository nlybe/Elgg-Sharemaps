<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

class DrawmapObject extends ElggObject {
    const SUBTYPE = "drawmapobject";
    
    protected $meta_defaults = array(
        "title" 		=> NULL,
        "coords" 	=> NULL,
        "object_id" 	=> NULL,
        "map_guid" 	=> NULL,
    );    

    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes["subtype"] = self::SUBTYPE;
    }
    
}
