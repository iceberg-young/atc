<?php
namespace atc\ast\head {

	class _if extends \atc\ast\head {

		public function __toString() {
			return "IF ({$this->condition}) {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createCondition() {
			$this->condition = $this->createDeriver( 'part\before', array( 'part\dirty' ) );
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\_call' ) );
		}

		/**
		 * Condition expression.
		 * @var \atc\ast\part\expression
		 */
		private $condition;

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
				'build' => 'createCondition',
			),
			array(
				'trait' => '{',
				'build' => 'createBody',
			),
		);

	}

}
