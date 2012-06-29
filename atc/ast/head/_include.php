<?php
namespace atc\ast\head {

	class _include extends \atc\ast\head {

		public function __toString() {
			return "INCLUDE \"{$this->path}\";" . $this->getDebugLocation();
		}

		protected function createPath( $c, $s ) {
			$this->path = $this->createDeriver( 'part\string', array( $c ) );
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
				'trait' => '#[`"\']#',
				'build' => 'createPath',
				're' => true,
			),
			array(
				'trait' => ';',
			),
		);

	}

}