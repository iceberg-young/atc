<?php
namespace atc\ast\head {

	class _rewind extends \atc\ast\head {

		public function __toString() {
			return "REWIND {$this->link};" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'link',
				'optional' => true,
			),
			array(
				'trait' => ';',
			),
		);

	}

}
