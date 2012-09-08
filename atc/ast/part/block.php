<?php
namespace atc\ast\part {

	class block extends \atc\ast\part {

		const DERIVER_PUSH = parent::DERIVER_PUSH_NONE;
		const COMPLETE_STATUS = parent::PUSH_COMPLETE;

		public function __construct( \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->current = call_user_func( $this->getChildCreator( array_slice( func_get_args(), 2 ) ) );
		}

		public function pushCondition() {
			return !$this->isShallow();
		}

	}

}
