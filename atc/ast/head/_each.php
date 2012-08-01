<?php
namespace atc\ast\head {

	class _each extends \atc\ast\head {

		public function __toString() {
			return "EACH ({$this->loop}) {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createLoop() {
			$this->loop = $this->createDeriver( 'part\before', array( 'part\dirty' ) );
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\_call' ) );
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
