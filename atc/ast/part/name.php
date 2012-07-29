<?php
namespace atc\ast\part {

	class name extends \atc\ast {

		public function __construct( $global, \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->rule = $global ? '/[\[\w\.\]]/' : '/\w/';
		}

		public function __toString() {
			return $this->content . $this->getDebugLocation();
		}

		public function push( $c ) {
			if ( preg_match( $this->rule, $c ) ) {
				$this->content .= $c;
				return parent::PUSH_CONTINUE;
			}
			else return parent::PUSH_OVERFLOW;
		}

		/**
		 * Parsed content.
		 * @var string
		 */
		private $content;

		/**
		 * Regular expression for checking content.
		 * @var string
		 */
		private $rule;

	}

}
