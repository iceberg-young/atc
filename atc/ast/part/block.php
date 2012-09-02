<?php
namespace atc\ast\part {

	class block extends \atc\ast\part {

		const DERIVER_PUSH = parent::DERIVER_PUSH_NONE;

		public function __construct( \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->content = call_user_func( $this->getChildCreator( array_slice( func_get_args(), 2 ) ) );
		}

		public function push( $c, $s ) {
			if ( !$this->isShallow() ) {
				$this->content->push( $c, $s );
				return parent::PUSH_CONTINUE;
			}
			else {
				$this->done();
				return parent::PUSH_COMPLETE;
			}
		}

	}

}
