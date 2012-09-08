<?php
namespace atc\ast\util {

	class series extends \atc\ast {

		public function __construct( \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->creator = $this->getChildCreator( array_slice( func_get_args(), 2 ) );
		}

		public function __toString() {
			return implode( ", ", $this->children );
		}

		public function onPush() {
			$status = parent::PUSH_CONTINUE;
			if ( (',' !== $this->fresh) || $this->isDeep() ) {
				if ( $this->current ) {
					switch ( $this->current->push( $this->fresh, $this->space ) ) {
						case parent::PUSH_OVERFLOW:
							$status = parent::PUSH_OVERFLOW;
						case parent::PUSH_COMPLETE:
							$this->children[] = $this->current;
							$this->current = null;
							break;
					}
				}
				elseif ( !$this->space ) {
					if ( $this->accept ) {
						$this->accept = false;
						$this->builder->markLocation();
						$this->current = call_user_func( $this->creator );
						return $this->onPush();
					}
					else $status = parent::PUSH_OVERFLOW;
				}
			}
			else {
				$this->accept = true;
				$this->onComplete();
			}
			return $status;
		}

		protected function onComplete() {
			if ( $this->current ) {
				$this->current->complete();
				$this->children[] = $this->current;
				$this->current = null;
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
