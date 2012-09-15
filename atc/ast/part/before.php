<?php
namespace atc\ast\part {

	class before extends \atc\ast\part {

		public function __construct( \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->current = call_user_func( $this->getChildCreator( array_slice( func_get_args(), 2 ) ) );
		}

		protected function pushCondition() {
			return (\atc\ast\head::BODY_TRAIT !== $this->fresh) || ($this->builder->getLevel() > $this->location->level + 1);
		}

	}

}
