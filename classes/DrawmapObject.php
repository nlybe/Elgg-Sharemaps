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
    
	public function __construct($guid = null) {
		if ($guid && !is_object($guid)) {
			// Loading entities via __construct(GUID) is deprecated, so we give it the entity row and the
			// attribute loader will finish the job. This is necessary due to not using a custom
			// subtype (see above).
			$guid = get_entity_as_row($guid);
		}		
		
		parent::__construct($guid);
	}    
    
}
