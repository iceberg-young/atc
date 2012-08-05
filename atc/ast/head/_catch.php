<?php
namespace atc\ast\head {

	class _catch extends \atc\ast\head {

		public function __toString() {
			return "CATCH ({$this->oops}) {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createOops() {
			return $this->createDeriver( 'part\block', array( 'part\dirty' ) );
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'oops',
				'trait' => '(',
			),
			array(
				'template' => 'body',
			),
		);

	}

}
