<?php
namespace atc\ast\head {

	class _veer extends \atc\ast\head {

		public function __toString() {
			return "VEER {$this->term};" . $this->getDebugLocation();
		}

		protected function createTerm() {
			return $this->appendChild( 'part\dirty' );
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
				'trait' => parent::END_TRAIT,
			),
		);

	}

}
