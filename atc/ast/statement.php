<?php
namespace atc\ast {

	class statement extends \atc\ast {

		const DERIVER_PUSH = parent::DERIVER_PUSH_PEND;

		public function __toString() {
			return "*[*{$this->me}*]*;" . $this->getDebugLocation();
		}

		public function push( $c ) {
			if ( !((';' === $c) && $this->isShallow()) ) {
				$this->me .= $c;
				return parent::PUSH_CONTINUE;
			}
			else return parent::PUSH_COMPLETE;
		}

		private $me;

	}

}
