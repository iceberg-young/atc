<?php
namespace atc\ast\part {

	class before extends \atc\ast {

		public function __construct( $type, \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$content = "\\atc\\ast\\$type";
			$this->body = new $content( $this->getBuilder(), $this );
		}

		public function __toString() {
			return $this->body->__toString();
		}

		public function push( $c, $s ) {
			if ( '{' !== $c ) {
				$this->body->push( $c, $s );
				return parent::PUSH_CONTINUE;
			}
			else return parent::PUSH_OVERFLOW;
		}

		/**
		 * Block content.
		 * @var \atc\ast
		 */
		private $body;

	}

}
