<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps
 */

namespace Elgg\Sharemaps;

use Elgg\Database\Seeds\Seed;

/**
 * Add sharemaps seed
 *
 * @access private
 */
class Seeder extends Seed {

	/**
	 * {@inheritdoc}
	 */
	public function seed() {

		$count_sharemaps = function () {
			return elgg_get_entities([
				'types' => 'object',
				'subtypes' => ElggMap::SUBTYPE,
				'metadata_names' => '__faker',
				'count' => true,
			]);
		};

		$this->advance($count_sharemaps());

		while ($count_sharemaps() < $this->limit) {
			$metadata = [
				'address' => $this->faker()->url,
			];

			$attributes = [
				'subtype' => ElggMap::SUBTYPE,
			];

			$map = $this->createObject($attributes, $metadata);

			if (!$map) {
				continue;
			}

			$this->createComments($map);
			$this->createLikes($map);

			elgg_create_river_item([
				'view' => 'river/object/sharemaps/create',
				'action_type' => 'create',
				'subject_guid' => $map->owner_guid,
				'object_guid' => $map->guid,
				'target_guid' => $map->container_guid,
			]);

			$this->advance();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function unseed() {

		$sharemaps = elgg_get_entities([
			'types' => 'object',
			'subtypes' => ElggMap::SUBTYPE,
			'metadata_names' => '__faker',
			'limit' => 0,
			'batch' => true,
		]);

		/* @var $sharemaps \ElggBatch */

		$sharemaps->setIncrementOffset(false);

		foreach ($sharemaps as $map) {
			if ($map->delete()) {
				$this->log("Deleted map $map->guid");
			} else {
				$this->log("Failed to delete map $map->guid");
			}

			$this->advance();
		}
	}
}
