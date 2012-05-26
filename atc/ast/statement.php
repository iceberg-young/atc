<?php
namespace atc\ast {

	class statement extends \atc\ast {

		const UNDISTINGUISHABLE = true;

		public function __toString() {
			return "^{$this->me}$" . json_encode( $this->getLocation() );
		}

		public function push( $c ) {
			if (';' !== $c) $this->me .= $c;
			else return true;
		}

		private $me;

	}

}
