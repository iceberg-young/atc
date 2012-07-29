<?php
namespace atc\ast\head {

	class _new extends \atc\ast\head {

		public function __toString() {
			return "NEW {$this->name} = {$this->value};" . $this->getDebugLocation();
		}

		protected function createName() {
			$this->name = $this->createDeriver( 'part\name', array( false ) );
		}

		protected function createValue() {
			$this->value = $this->createDeriver( 'part\dirty' );
		}

		private $name;
		private $value;

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'trait' => '#[a-z]#i',
				'build' => 'createName',
			),
			array(
				'trait' => '=',
			),
			array(
				'build' => 'createValue',
			),
			array(
				'trait' => ';',
			),
		);

	}

}
