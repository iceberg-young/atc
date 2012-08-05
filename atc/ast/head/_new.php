<?php
namespace atc\ast\head {

	class _new extends \atc\ast\head {

		public function __toString() {
			return "NEW {$this->name} : {$this->value};" . $this->getDebugLocation();
		}

		protected function createValue() {
			return $this->createDeriver( 'part\dirty' );
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
				'trait' => ':',
			),
			array(
				'template' => 'value',
			),
			array(
				'trait' => ';',
			),
		);

	}

}
