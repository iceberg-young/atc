<?php
namespace atc\ast\part {

	class before extends \atc\ast\part {

		public function __construct( $type, \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->createContent( $type );
		}

		public function push( $c, $s ) {
			if ( '{' !== $c ) {
				$this->content->push( $c, $s );
				return parent::PUSH_CONTINUE;
			}
			else return parent::PUSH_OVERFLOW;
		}

	}

}
