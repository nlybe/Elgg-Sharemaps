<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

class ElggMap extends ElggFile {
    const SUBTYPE = "sharemaps";
    
    protected $meta_defaults = array(
        "title" => NULL,
        "description" => NULL,
        "tags"  => NULL,
        "comments_on" => NULL,
    ); 
    
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes["subtype"] = self::SUBTYPE;
    }
    
    public function __construct($guid = null) {
        if ($guid && !is_object($guid)) {
            $guid = get_entity_as_row($guid);
        }		

        parent::__construct($guid);
    }

    /**
     * Can a user comment on this sharemap post?
     *
     * @see ElggObject::canComment()
     *
     * @param int  $user_guid User guid (default is logged in user)
     * @param bool $default   Default permission
     *
     * @return bool
     */
    public function canComment($user_guid = 0, $default = null): bool {        
        $result = parent::canComment($user_guid, $default);
		if ($result == false) {
			return $result;
		}

		if ($this->comments_on === 'Off') {
            return false;
        }

        return true;
    }  
    
    /**
     * Get the filetype of this map
     *
     * @return string
     */
    public function getMapType() {    
        $allowed_map_types = ['gpx', 'kml'];
        
        $mapfile = $this->getFilenameOnFilestore();
        foreach ($allowed_map_types as $ft) {
            if (strripos($mapfile, ".{$ft}") !== false) {
                return $ft;
            }    
        }

        return false;
    }  
}

