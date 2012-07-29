<?php
namespace atc\ast\part {

	class dirty extends \atc\ast {

		const DERIVER_PUSH = parent::DERIVER_PUSH_PEND;

		public function __toString() {
			return "*(*$this->content*)*" . $this->getDebugLocation();
		}

		public function push( $c ) {
			if ( !((';' === $c) && $this->isShallow()) ) {
				$this->content .= $c;
				return parent::PUSH_CONTINUE;
			}
			else return parent::PUSH_OVERFLOW;
		}

		/**
		 * Parsed content.
		 * @var string
		 */
		private $content;

	}

}
