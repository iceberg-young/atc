<?php
namespace atc\ast\head {

	class _veer extends \atc\ast\head {

		public function __toString() {
			return "VEER {$this->case};" . $this->getDebugLocation();
		}

		protected function createCase() {
			$this->case = $this->createDeriver( 'part\dirty' );
		}

		private $case;

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'build' => 'createCase',
			),
			array(
				'trait' => ';',
			),
		);

	}

}
