<?php
namespace atc\ast\head {

	class _else extends \atc\ast\head {

		public function __toString() {
			return "ELSE {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\call' ), false );
		}

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
				'trait' => '/{/',
				'build' => 'createBody',
			),
		);

	}

}
