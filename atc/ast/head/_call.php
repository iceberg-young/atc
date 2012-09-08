<?php
namespace atc\ast\head {

	class _call extends \atc\ast\head {

		public function __toString() {
			return "CALL {$this->access}{$this->locate}{$this->name} {{$this->template}} ({$this->parameter}) [\n{$this->body}\n]" . $this->getDebugLocation();
		}

		protected function createParameter() {
			return $this->appendChild( 'part\block', 'util\series', 'head\_as\_function' );
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
				'template' => 'template',
				'optional' => true,
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
