<?php
namespace atc\ast\head {

	class statement extends \atc\ast\head {

		const DERIVER_PUSH = parent::DERIVER_PUSH_PEND;

		public function __toString() {
			return "{$this->term};" . $this->getDebugLocation();
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
				'trait' => ';',
			),
		);

	}

}
