<?php
namespace atc {

	abstract class ast {

		public function __construct( builder $builder, $parent = null ) {
			$this->builder = $builder;
			$this->parent = $parent;

			$this->location = (object) $this->builder->getLocation();
			$this->location->type = get_class( $this );
		}

		public function getBuilder() {
			return $this->builder;
		}

		public function getLocation() {
			return $this->location;
		}

		public function getParent() {
			return $this->parent;
		}

		public function isIntact() {
			return $this->intact;
		}

		public function isDeep() {
			return $this->builder->getLevel() > $this->location->level;
		}

		public function isShallow() {
			return $this->builder->getLevel() < $this->location->level;
		}

		const PUSH_CONTINUE = 'continue';
		const PUSH_COMPLETE = 'complete';
		const PUSH_OVERFLOW = 'overflow';

		public function push( $c, $s ) {
			$this->fresh = $c;
			$this->space = $s;
			if ( !$this->current ) {
				$status = self::PUSH_CONTINUE;
				if ( $this->intact && !$this->space ) {
					$this->builder->markLocation();
					$this->intact = false;
					$this->fragment = '';
					$this->length = 0;
				}
				if ( !$this->intact ) {
					switch ( $this->filterDeriver() ) {
						case self::FILTER_CONTINUE:
							if ( $this->space ) trigger_error( "unexpected space in pending part.", E_USER_ERROR );
							$this->fragment .= $this->fresh;
							$this->length += strlen( $this->fresh );
							break;

						case self::FILTER_TERMINAL:
							if ( $this->ending ) {
								$status = self::PUSH_COMPLETE;
							} // goto FILTER_COMPLETE

						case self::FILTER_COMPLETE:
							$this->intact = true;
							$this->fragment = '';
							$this->length = 0;
							break;
					}
				}
			}
			else $status = $this->transfer();
			return $status;
		}

		public function comment( $blank ) {
			if ( $this->current ) {
				$comment = $this->current->comment( $blank );
			}
			elseif ( !$blank && $this->previous ) {
				$comment = $this->previous->comment( $blank );
			}
			else {
				$comment = new ast\part\comment( $this->builder, $this );
				$this->comments[] = $comment;
			}
			return $comment;
		}

		const DERIVER_PUSH_PEND = 'pend';
		const DERIVER_PUSH_LAST = 'last';
		const DERIVER_PUSH_NONE = 'none';
		const DERIVER_PUSH = self::DERIVER_PUSH_LAST;

		protected function getChildCreator( array $args ) {
			$type = array_shift( $args );
			array_unshift( $args, $this->builder, $this );
			$class = new \ReflectionClass( "atc\\ast\\$type" );
			return function() use($class, $args) {
				return $class->newInstanceArgs( $args );
			};
		}

		protected function appendChild() {
			$creator = $this->getChildCreator( func_get_args() );
			$child = $this->current = call_user_func( $creator );

			switch ( $child::DERIVER_PUSH ) {
				case self::DERIVER_PUSH_PEND:
					foreach ( str_split( $this->fragment ) as $p ) {
						$status = $this->current->push( $p, false );
						if ( ast::PUSH_CONTINUE !== $status ) {
							trigger_error( "cannot back off ($type) when create deriver", E_USER_WARNING );
						}
					} // goto DERIVER_PUSH_LAST

				case self::DERIVER_PUSH_LAST:
					$status = $this->current->push( $this->fresh, $this->space );
					if ( ast::PUSH_OVERFLOW === $status ) {
						trigger_error( "cannot back off ($type) when create deriver", E_USER_WARNING );
					}
					break;
			}

			return $this->current;
		}

		const FILTER_CONTINUE = 'continue';
		const FILTER_COMPLETE = 'complete';
		const FILTER_TERMINAL = 'terminal';

		protected function filterDeriver() {
			trigger_error( __METHOD__ . ' must be overrided!', E_USER_ERROR );
		}

		protected function getDebugLocation() {
			return "\t#" . json_encode( $this->getLocation() ) . "\n";
		}

		protected function markEnding() {
			$this->ending = true;
		}

		private function transfer() {
			$status = $this->current->push( $this->fresh, $this->space );
			if ( self::PUSH_CONTINUE !== $status ) {
				$this->previous = $this->current;
				$this->current = null;
				$this->intact = true;
				$this->builder->clearLocation();
				if ( !$this->ending ) {
					$status = self::PUSH_OVERFLOW === $status ? $this->push( $this->fresh, $this->space ) : self::PUSH_CONTINUE;
				}
			}
			return $status;
		}

		/**
		 * Pushed part during deriver filtering.
		 * @var string
		 */
		protected $fragment;

		/**
		 * Newly pushed literal.
		 * @var string
		 */
		protected $fresh;

		/**
		 * Space indicator of newly pushed literal.
		 * @var boolean
		 */
		protected $space;

		/**
		 * Length of $fragment.
		 * @var number
		 */
		protected $length;

		/**
		 * Inferior nodes.
		 * @var array
		 */
		protected $children = array( );

		/**
		 * Current node.
		 * @var \atc\ast
		 */
		private $current;

		/**
		 * Previous node.
		 * @var \atc\ast
		 */
		private $previous;

		/**
		 * Current builder.
		 * @var \atc\misc\builder
		 */
		private $builder;

		/**
		 * Location of the source beginning.
		 * @var object
		 */
		private $location;

		/**
		 * Superior node.
		 * @var \atc\ast
		 */
		private $parent;

		/**
		 * Is constructing node?
		 * @var boolean
		 */
		private $intact = true;

		/**
		 * Is the last node?
		 * @var boolean
		 */
		private $ending = false;

		/**
		 * Comments.
		 * @var array
		 */
		private $comments = array( );

	}

}
