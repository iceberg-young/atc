<?php
namespace atc\ast\part {

	class name extends \atc\ast\part {

		public function __construct( \atc\builder $builder, $parent, $global ) {
			parent::__construct( $builder, $parent );
			$this->rule = $global ? '#[\[\w\.\]]#' : '#\w#';
		}

		protected function pushCondition() {
			return preg_match( $this->rule, $this->fresh );
		}

		/**
		 * Regular expression for checking content.
		 * @var string
		 */
		private $rule;

	}

}
