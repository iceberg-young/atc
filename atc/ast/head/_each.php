<?php
namespace atc\ast\head {

	class _each extends \atc\ast\head {

		public function __toString() {
			return "EACH ({$this->loop}) {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createLoop( $c, $s ) {
			$this->loop = $this->createDeriver( 'part\before', array( 'part\dirty' ) );
			$this->loop->push( $c, $s );
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\call' ) );
		}

		/**
		 * Condition expression.
		 * @var \atc\ast\part\expression
		 */
		private $loop;

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
				'build' => 'createLoop',
			),
			array(
				'trait' => '{',
				'build' => 'createBody',
			),
		);

	}

}