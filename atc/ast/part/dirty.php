<?php
namespace atc\ast\part {

	class dirty extends \atc\ast\part {

		const DERIVER_PUSH = parent::DERIVER_PUSH_PEND;

		public function push( $c ) {
			if ( (';' !== $c) || $this->isDeep() ) {
				$this->content .= $c;
				return parent::PUSH_CONTINUE;
			}
			else {
				$this->done();
				return parent::PUSH_OVERFLOW;
			}
		}

	}

}
