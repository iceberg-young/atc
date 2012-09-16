<?php
namespace atc\ast\head {

	class _call extends \atc\ast\head {

		public function __toString() {
			return "CALL {$this->access}{$this->locate}{$this->name} {{$this->type_parameters}} ({$this->call_parameters}) [\n{$this->body}\n]" . $this->getDebugLocation();
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
				'template' => 'type_parameters',
				'optional' => true,
			),
			array(
				'template' => 'call_parameters',
			),
			array(
				'template' => 'body',
			),
		);

	}

}
