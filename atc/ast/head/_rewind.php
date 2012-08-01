<?php
namespace atc\ast\head {

	class _rewind extends \atc\ast\head {

		public function __toString() {
			return "REWIND {$this->name};" . $this->getDebugLocation();
		}

		protected function createName() {
			$this->name = $this->createDeriver( 'part\name', array( false ) );
		}

		private $name;

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'trait' => '#[a-z]#i',
				'build' => 'createName',
				'optional' => true,
			),
			array(
				'trait' => ';',
			),
		);

	}

}
