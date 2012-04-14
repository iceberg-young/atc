<?php
namespace atc\ast\prefix {

	class _require {

		public function __toString() {
			return "^^REQUIRE " . $this->me . "$$";
		}

		public function push( $c ) {
			$this->me .= $c;
			return ';' === $c;
		}

		private $me;

	}

}
