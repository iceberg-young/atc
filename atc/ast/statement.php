<?php
namespace atc\ast {

	class statement extends \atc\ast {

		public function __construct( \atc\builder $builder, $prefix = '' ) {
			$this->builder = $builder;
			$this->me = $prefix;
		}

		public function __toString() {
			return "^" . $this->me . "$";
		}

		public function push( $c ) {
			$this->me .= $c;
			return ';' === $c;
		}

		private $me;

	}

}
