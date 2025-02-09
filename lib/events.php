<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

 /**
 * Add a menu item to an ownerblock
 *
 * @param \Elgg\Event $event 'register', 'menu:owner_block'
 *
 * @return ElggMenuItem[]
 */
function sharemaps_owner_block_menu(\Elgg\Event $event) {

	$entity = $event->getEntityParam();
	$return = $event->getValue();
	
	if ($entity instanceof \ElggUser) {
		$url = elgg_generate_url('collection:object:sharemaps:owner', ['username' => $entity->username]);
		$item = new ElggMenuItem('sharemaps', elgg_echo('collection:object:sharemaps'), $url);
		$return[] = $item;
	} elseif ($entity instanceof \ElggGroup) {
		if ($entity->isToolEnabled('sharemaps')) {
			$url = elgg_generate_url('collection:object:sharemaps:group', ['guid' => $entity->guid]);
			$item = new ElggMenuItem('sharemaps', elgg_echo('collection:object:sharemaps:group'), $url);
			$return[] = $item;
		}
	}
	
	return $return;
}
