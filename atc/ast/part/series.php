<?php
namespace atc\ast\part {

	class series extends \atc\ast\part {

		public function __construct() {
			$this->creator = $this->createContent( func_get_args() );
			$this->children[] = $this->content;
		}

		public function __toString() {
			return implode( ", ", $this->children );
		}

		public function push( $c, $s ) {
			if ( (',' !== $c) || $this->isDeep() ) {
				if ( !($this->content || $s) ) return parent::PUSH_OVERFLOW;
				switch ( $this->content->push( $c, $s ) ) {
					case parent::PUSH_COMPLETE:
						$this->content = null;
						break;
					case parent::PUSH_OVERFLOW:
						return parent::PUSH_OVERFLOW;
				}
			}
			else {
				$this->children[] = $this->content = call_user_func( $this->creator );
			}
			return parent::PUSH_CONTINUE;
		}

		/**
		 * Children creator.
		 * @var \ReflectionClass
		 */
		private $creator;

	}

}
