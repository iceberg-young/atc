<?php
namespace atc\ast\head {

	class _break extends \atc\ast\head {

		public function __toString() {
			return "BREAK {$this->link};" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'link',
				'optional' => true,
			),
			array(
				'trait' => parent::END_TRAIT,
			),
		);

	}

}
