<?php
namespace atc\ast\head {

	class _alias extends \atc\ast\head {

		public function __toString() {
			return "ALIAS {$this->name} : {$this->link};" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'name',
			),
			array(
				'trait' => ':',
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
