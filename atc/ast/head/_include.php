<?php
namespace atc\ast\head {

	class _include extends \atc\ast\head {

		public function __toString() {
			return "INCLUDE {$this->path};" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'path',
			),
			array(
				'trait' => ';',
			),
		);

	}

}
