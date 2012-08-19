<?php
namespace atc\ast\part {

	class block extends \atc\ast\part {

		const DERIVER_PUSH = parent::DERIVER_PUSH_NONE;

		public function __construct( $type, \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->createContent( $type );
		}

		public function push( $c, $s ) {
			if ( $this->isDeep() ) {
				$this->content->push( $c, $s );
				return parent::PUSH_CONTINUE;
			}
			else return parent::PUSH_COMPLETE;
		}

	}

}
