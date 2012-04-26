<?php
namespace atc\ast\head {

	class _do extends \atc\ast\head {

		public function __toString() {
			return "^^DO {$this->body}$$" . json_encode( $this->getSource() );
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\call' ), false, true );
		}

		private $body;
		protected static $patterns = array(
			array(
				'trait' => array( '{' ),
				'build' => 'createBody',
			),
		);

	}

}
