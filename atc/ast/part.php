<?php
namespace atc\ast {

	class part extends \atc\ast {

		public function __toString() {
			return $this->content . $this->getDebugLocation();
		}

		protected function createContent( $args ) {
			list($builder, $parent) = array_splice( $args, 0, 2 );
			parent::__construct( $builder, $parent );
			$creator = $this->getChildCreator( $args );
			$this->content = call_user_func( $creator );
			return $creator;
		}

		/**
		 * Parsed content.
		 * @var mixed
		 */
		protected $content;

	}

}
