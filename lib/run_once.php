<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */
 
function sharemaps_manager_run_once_subtypes()	{
	
    //add_subtype('object', Drawmap::SUBTYPE, "Drawmap");
    add_subtype('object', DrawmapObject::SUBTYPE, "DrawmapObject");
    add_subtype('object', Drawmap::SUBTYPE, "Drawmap");
	
}
