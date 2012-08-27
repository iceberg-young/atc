<?php
namespace atc\ast\part {

	class block extends \atc\ast\part {

		const DERIVER_PUSH = parent::DERIVER_PUSH_NONE;

		public function __construct() {
			$this->createContent( func_get_args() );
		}

		public function push( $c, $s ) {
			if ( !$this->isShallow() ) {
				$this->content->push( $c, $s );
				return parent::PUSH_CONTINUE;
			}
			else return parent::PUSH_COMPLETE;
		}

	}

}
