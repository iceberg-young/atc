<?php
namespace atc\ast\part {

	class before extends \atc\ast\part {

		public function __construct() {
			$this->createContent( func_get_args() );
		}

		public function push( $c, $s ) {
			if ( \atc\ast\head::BODY_TRAIT !== $c ) {
				$this->content->push( $c, $s );
				return parent::PUSH_CONTINUE;
			}
			else return parent::PUSH_OVERFLOW;
		}

	}

}
