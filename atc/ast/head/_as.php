<?php
namespace atc\ast\head {

	class _as extends \atc\ast\head {

		public function __toString() {
			return "{$this->name} AS {$this->link}" . $this->getDebugLocation();
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
				'trait' => 'as',
			),
			array(
				'template' => 'link',
			),
		);

	}

}
