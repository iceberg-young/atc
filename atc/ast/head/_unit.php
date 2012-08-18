<?php
namespace atc\ast\head {

	class _unit extends \atc\ast\head {

		public function __toString() {
			return "UNIT {$this->access}{$this->static}{$this->name} OF {$this->link};" . $this->getDebugLocation();
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
				'template' => 'static',
				'optional' => true,
			),
			array(
				'template' => 'name',
			),
			array(
				'trait' => 'of',
			),
			array(
				'template' => 'link',
			),
			array(
				'trait' => ';',
			),
		);

	}

}
