<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */
 
class SharemapsPluginMap extends ElggFile {
	protected function  initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "sharemaps";
	}

	public function __construct($guid = null) {
		if ($guid && !is_object($guid)) {
			$guid = get_entity_as_row($guid);
		}		
		
		parent::__construct($guid);
	}

	public function delete() {
		$thumbnails = array($this->thumbnail, $this->smallthumb, $this->largethumb);
		foreach ($thumbnails as $thumbnail) {
			if ($thumbnail) {
				$delfile = new ElggFile();
				$delfile->owner_guid = $this->owner_guid;
				$delfile->setFilename($thumbnail);
				$delfile->delete();
			}
		}

		return parent::delete();
	}
}
