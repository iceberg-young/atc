<?php
namespace atc\ast\head {

	class _scope extends \atc\ast\head {

		public function __toString() {
			return "SCOPE {$this->name} {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createName( $c, $s ) {
			$this->name = $this->createDeriver( 'part\name', array( false ) );
			$this->name->push( $c, $s );
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\scope' ) );
		}

		/**
		 * Scope name, optional.
		 * @var \atc\ast\part\name
		 */
		private $name;

		/**
		 * @var \atc\ast\part\block
		 */
		private $body;

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'trait' => '#[a-z]#i',
				'build' => 'createName',
				'optional' => true,
			),
			array(
				'trait' => '{',
				'build' => 'createBody',
			),
		);

	}

}
