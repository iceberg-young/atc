<?php
namespace atc\ast\part {

	class name extends \atc\ast\part {

		public function __construct( $global, \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->rule = $global ? '#[\[\w\.\]]#' : '#\w#';
		}

		public function push( $c, $s ) {
			if ( preg_match( $this->rule, $c ) ) {
				$this->content .= $c;
				return parent::PUSH_CONTINUE;
			}
			else return parent::PUSH_OVERFLOW;
		}

		/**
		 * Regular expression for checking content.
		 * @var string
		 */
		private $rule;

	}

}
