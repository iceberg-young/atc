<?php
namespace atc\ast\part {

	class dirty extends \atc\ast\part {

		const DERIVER_PUSH = parent::DERIVER_PUSH_PEND;

		public function push( $c ) {
			if ( !((';' === $c) && $this->isShallow()) ) {
				$this->content .= $c;
				return parent::PUSH_CONTINUE;
			}
			else return parent::PUSH_OVERFLOW;
		}

	}

}
