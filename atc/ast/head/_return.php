<?php
namespace atc\ast\head {

	class _return extends \atc\ast\head {

		public function __toString() {
			return "RETURN;" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'trait' => parent::END_TRAIT,
			),
		);

	}

}
