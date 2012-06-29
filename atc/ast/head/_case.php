<?php
namespace atc\ast\head {

	class _case extends \atc\ast\head {

		public function __toString() {
			return "CASE {$this->name} {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createName( $c, $s ) {
			$this->name = $this->createDeriver( 'part\before', array( 'part\dirty' ) );
			$this->name->push( $c, $s );
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\call' ) );
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
				'build' => 'createName',
			),
			array(
				'trait' => '{',
				'build' => 'createBody',
			),
		);

	}

}