<?php
namespace atc\ast\head {

	class _class extends \atc\ast\head {

		public function __toString() {
			return "CLASS {$this->access}{$this->final}{$this->name} [\n{$this->body}\n]" . $this->getDebugLocation();
		}

		protected function createBody() {
			return $this->appendChild( 'part\block', 'body\_class' );
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'access',
				'optional' => true,
			),
			array(
				'template' => 'final',
				'optional' => true,
			),
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
