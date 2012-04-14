<?php
namespace atc\ast\prefix {

	class _let extends \atc\ast {

		public function __toString() {
			return "^^LET " . $this->me . "$$";
		}

		public function push( $c ) {
			$this->me .= $c;
			return ';' === $c;
		}

		private $me;

	}

}
