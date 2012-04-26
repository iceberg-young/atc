<?php
namespace atc\ast\head {

	class _scope extends \atc\ast\head {

		public function __toString() {
			return "^^SCOPE {$this->name} {$this->body}$$" . json_encode( $this->getSource() );
		}

		protected function createName() {
			$this->name = $this->createDeriver( 'part\name' );
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\call' ), false, true );
		}

		private $name;
		private $body;
		protected static $patterns = array(
			array(
				'trait' => '#[a-z]#i',
				'build' => 'createName',
				'optional' => true,
			),
			array(
				'trait' => '#{#',
				'build' => 'createBody',
			),
		);

	}

}
