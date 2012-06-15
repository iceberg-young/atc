<?php
namespace atc\ast\part {

	class block extends \atc\ast {

		public function __construct( $type, \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$content = "\\atc\\ast\\$type";
			$this->body = new $content( $this->getBuilder(), $this );
		}

		public function __toString() {
			return $this->body->__toString();
		}

		public function push( $c, $s ) {
			if ( $this->isDeep() ) $this->body->push( $c, $s );
			else return true;
		}

		/**
		 * Block content.
		 * @var \atc\ast
		 */
		private $body;

	}

}
