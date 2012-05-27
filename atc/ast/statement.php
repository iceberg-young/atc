<?php
namespace atc\ast {

	class statement extends \atc\ast {

		const UNDISTINGUISHABLE = true;

		public function __toString() {
			return "*[*{$this->me}*]*;" . $this->getDebugLocation();
		}

		public function push( $c ) {
			if ( (';' === $c) && $this->isShallow() ) return true;
			else $this->me .= $c;
		}

		private $me;

	}

}
