<?php
namespace atc\ast\head {

	class _of extends \atc\ast\head {

		public function __toString() {
			return "{$this->name} OF {$this->link}" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'name',
			),
			array(
				'trait' => 'of',
			),
			array(
				'template' => 'link',
			),
		);

	}

}
