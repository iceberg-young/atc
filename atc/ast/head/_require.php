<?php
namespace atc\ast\head {

	class _require extends \atc\ast\head {

		public function __toString() {
			return "^^REQUIRE {$this->path};$$" . json_encode( $this->getSource() );
		}

		protected function createPath( $c ) {
			$this->path = $this->createDeriver( 'part\string', array( $c ), false );
		}

		private $path;
		protected static $patterns = array(
			array(
				'trait' => array( '"', "'" ),
				'build' => 'createPath',
			),
			array(
				'trait' => array( ';' ),
			),
		);

	}

}
