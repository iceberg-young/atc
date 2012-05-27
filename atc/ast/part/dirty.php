<?php
namespace atc\ast\part {

	class dirty extends \atc\ast {

		public function __toString() {
			return "*(*$this->content*)*" . $this->getDebugLocation();
		}

		public function push( $c ) {
			if ( (';' === $c) && $this->isShallow() ) return false;
			else $this->content .= $c;
		}

		/**
		 * Parsed content.
		 * @var string
		 */
		private $content;

	}

}
