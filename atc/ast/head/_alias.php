<?php
namespace atc\ast\head {

	class _alias extends \atc\ast\head {

		public function __toString() {
			return "ALIAS {$this->alias} = {$this->refer};" . $this->getDebugLocation();
		}

		protected function createAlias( $c ) {
			$this->alias = $this->createDeriver( 'part\name', array( false ) );
		}

		protected function createRefer( $c ) {
			$this->refer = $this->createDeriver( 'part\name', array( true ) );
		}

		/**
		 * @var \atc\ast\part\name
		 */
		private $alias;

		/**
		 * @var \atc\ast\part\name
		 */
		private $refer;

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'trait' => '/[a-z]/i',
				'build' => 'createAlias',
			),
			array(
				'trait' => '/=/',
			),
			array(
				'trait' => '/[a-z]/i',
				'build' => 'createRefer',
			),
			array(
				'trait' => '/;/',
			),
		);

	}

}
