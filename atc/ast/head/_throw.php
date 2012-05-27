<?php
namespace atc\ast\head {

	class _throw extends \atc\ast\head {

		public function __toString() {
			return "THROW {$this->oops};" . $this->getDebugLocation();
		}

		protected function createOops( $c ) {
			$this->oops = $this->createDeriver( 'part\dirty' );
		}

		private $oops;

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'trait' => '/./',
				'build' => 'createOops',
			),
			array(
				'trait' => '/;/',
			),
		);

	}

}
