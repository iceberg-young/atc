<?php
namespace atc\ast\head {

	class _new extends \atc\ast\head {

		public function __toString() {
			return "NEW {$this->name} = {$this->value};" . $this->getDebugLocation();
		}

		protected function createName( $c, $s ) {
			$this->name = $this->createDeriver( 'part\name', array( false ) );
			$this->name->push( $c, $s );
		}

		protected function createValue( $c, $s ) {
			$this->value = $this->createDeriver( 'part\dirty' );
			$this->value->push( $c, $s );
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
				're' => true,
			),
			array(
				'trait' => '=',
			),
			array(
				'trait' => '#.#',
				'build' => 'createValue',
				're' => true,
			),
			array(
				'trait' => ';',
			),
		);

	}

}
