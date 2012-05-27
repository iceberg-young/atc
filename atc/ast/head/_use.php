<?php
namespace atc\ast\head {

	class _use extends \atc\ast\head {

		public function __toString() {
			return "USE {$this->name} = {$this->value};" . $this->getDebugLocation();
		}

		protected function createName( $c ) {
			$this->name = $this->createDeriver( 'part\name', array( false ) );
		}

		protected function createValue( $c ) {
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
				'trait' => '/[a-z]/i',
				'build' => 'createName',
			),
			array(
				'trait' => '/=/',
			),
			array(
				'trait' => '/./',
				'build' => 'createValue',
			),
			array(
				'trait' => '/;/',
			),
		);

	}

}
