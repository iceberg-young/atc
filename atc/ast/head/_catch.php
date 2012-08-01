<?php
namespace atc\ast\head {

	class _catch extends \atc\ast\head {

		public function __toString() {
			return "CATCH ({$this->oops}) {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createOops() {
			$this->oops = $this->createDeriver( 'part\block', array( 'part\dirty' ) );
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\_call' ) );
		}

		/**
		 * Exception parameter.
		 * @var \atc\ast\part\expression
		 */
		private $oops;

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
				'trait' => '(',
				'build' => 'createOops',
			),
			array(
				'trait' => '{',
				'build' => 'createBody',
			),
		);

	}

}
