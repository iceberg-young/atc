<?php
namespace atc\ast\part {

	class before extends \atc\ast\part {

		public function __construct( \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->content = call_user_func( $this->getChildCreator( array_slice( func_get_args(), 2 ) ) );
		}

		public function push( $c, $s ) {
			if ( \atc\ast\head::BODY_TRAIT !== $c ) {
				$this->content->push( $c, $s );
				return parent::PUSH_CONTINUE;
			}
			else {
				$this->done();
				return parent::PUSH_OVERFLOW;
			}
		}

	}

}
