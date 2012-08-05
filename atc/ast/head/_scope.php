<?php
namespace atc\ast\head {

	class _scope extends \atc\ast\head {

		public function __toString() {
			return "SCOPE {$this->name} {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createBody() {
			return $this->createDeriver( 'part\block', array( 'body\_scope' ) );
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'name',
				'optional' => true,
			),
			array(
				'template' => 'body',
			),
		);

	}

}
