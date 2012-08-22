<?php
namespace atc\ast\head {

	class _switch extends \atc\ast\head {

		public function __toString() {
			return "SWITCH {$this->term} [\n{$this->body}\n]" . $this->getDebugLocation();
		}

		protected function createBody() {
			return $this->createDeriver( 'part\block', array( 'body\_switch' ) );
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'term',
			),
			array(
				'template' => 'body',
			),
		);

	}

}
