<?php
namespace atc\ast\head {

	class _include extends \atc\ast\head {

		public function __toString() {
			return "INCLUDE \"{$this->path}\";" . $this->getDebugLocation();
		}

		protected function createPath( $c ) {
			$this->path = $this->createDeriver( 'part\string', array( $c ), false );
		}

		/**
		 * @var \atc\ast\part\string
		 */
		private $path;

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'trait' => '/[`"\']/',
				'build' => 'createPath',
			),
			array(
				'trait' => '/;/',
			),
		);

	}

}
