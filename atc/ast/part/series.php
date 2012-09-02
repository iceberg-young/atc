<?php
namespace atc\ast\part {

	class series extends \atc\ast\part {

		public function __construct( \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->creator = $this->getChildCreator( array_slice( func_get_args(), 2 ) );
		}

		public function __toString() {
			return implode( ", ", $this->children );
		}

		public function push( $c, $s ) {
			$status = parent::PUSH_CONTINUE;
			if ( (',' !== $c) || $this->isDeep() ) {
				if ( $this->content ) {
					switch ( $this->content->push( $c, $s ) ) {
						case parent::PUSH_OVERFLOW:
							$status = parent::PUSH_OVERFLOW;
							parent::done();
						case parent::PUSH_COMPLETE:
							$this->children[] = $this->content;
							$this->content = null;
							break;
					}
				}
				elseif ( !$s ) {
					if ( $this->accept ) {
						$this->accept = false;
						$this->content = call_user_func( $this->creator );
						return $this->push( $c, $s );
					}
					else {
						$status = parent::PUSH_OVERFLOW;
						parent::done();
					}
				}
			}
			else {
				$this->accept = true;
				$this->appendLast();
			}
			return $status;
		}

		public function done() {
			parent::done();
			$this->appendLast();
		}

		private function appendLast() {
			if ( $this->content ) {
				$this->content->done();
				$this->children[] = $this->content;
				$this->content = null;
			}
		}

		/**
		 * Can accept more nodes.
		 * @var boolean
		 */
		private $accept = true;

		/**
		 * Children creator.
		 * @var \ReflectionClass
		 */
		private $creator;

	}

}
