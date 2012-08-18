<?php
namespace atc\ast\head {

	class _base extends \atc\ast\head {

		public function __toString() {
			return "BASE {$this->access}{$this->virtual}{$this->link};" . $this->getDebugLocation();
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
				'template' => 'virtual',
				'optional' => true,
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
