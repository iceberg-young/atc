<?php
namespace atc\ast\head {

	class _throw extends \atc\ast\head {

		public function __toString() {
			return "THROW {$this->oops};" . $this->getDebugLocation();
		}

		protected function createOops() {
			return $this->appendChild( 'part\dirty' );
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'oops',
			),
			array(
				'trait' => ';',
			),
		);

	}

}
