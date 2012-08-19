<?php
namespace atc\ast\head {

	class _call extends \atc\ast\head {

		public function __toString() {
			return "CALL {$this->access}{$this->locate}{$this->name} ({$this->parameter}) {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createParameter() {
			return $this->createDeriver( 'part\block', array( 'part\dirty' ) );
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
				'template' => 'locate',
				'optional' => true,
			),
			array(
				'template' => 'name',
			),
			array(
				'trait' => '(',
				'template' => 'parameter',
			),
			array(
				'template' => 'body',
			),
		);

	}

}
