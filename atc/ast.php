<?php
namespace atc {

	abstract class ast {

		public function __construct( builder $builder, $parent = null ) {
			$this->parent = $parent;
			$this->builder = $builder;

			$this->location = $this->builder->readLocation();

			$this->log = new log( $this->builder, get_class( $this ) );
		}

		public function getParent() {
			return $this->parent;
		}

		public function getBuilder() {
			return $this->builder;
		}

		public function getLocation() {
			return $this->location;
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
			if ( $this->complete ) {
				$this->log()->debug( "Pushing ($c) to a complete node." );
				return self::PUSH_OVERFLOW;
			}

			$this->fresh = $c;
			$this->space = $s;
			if ( !$this->current ) {
				$status = self::PUSH_CONTINUE;
				if ( !($this->filter || $this->space) ) {
					$this->builder->markLocation();
					$this->fragment = '';
					$this->length = 0;
					$this->filter = true;
				}
				if ( $this->filter ) {
					$this->filterDeriver();
					if ( $this->filter ) {
						if ( $this->space ) {
							$fragment = $this->getFragmentLog();
							$this->log()->debug( "Child node must be identified from $fragment." );
						}
						$this->fragment .= $this->fresh;
						$this->length += strlen( $this->fresh );
					}
					elseif ( $this->ending && !$this->current ) {
						$status = self::PUSH_COMPLETE;
						$this->done();
					}
				}
			}
			else $status = $this->transfer();
			return $status;
		}

		public function done() {
			if ( $this->complete ) {
				return $this->log()->debug( 'Completion has already been notified.' );
			}
			if ( $this->filter ) {
				$fragment = $this->getFragmentLog();
				$this->log()->error( "Has unidentified content $fragment." );
			}
			$this->complete = true;
			if ( $this->current ) {
				$this->current->done();
				$this->current = null;
			}
			$this->fragment = null;
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

		protected function getChildCreator( array $args ) {
			$type = array_shift( $args );
			array_unshift( $args, $this->builder, $this );
			$class = new \ReflectionClass( "atc\\ast\\$type" );
			return function() use($class, $args) {
				return $class->newInstanceArgs( $args );
			};
		}

		const DERIVER_PUSH_PEND = 'pend';
		const DERIVER_PUSH_LAST = 'last';
		const DERIVER_PUSH_NONE = 'none';
		const DERIVER_PUSH = self::DERIVER_PUSH_LAST;

		protected function appendChild() {
			$child = $this->current = call_user_func( $this->getChildCreator( func_get_args() ) );
			switch ( $child::DERIVER_PUSH ) {
				case self::DERIVER_PUSH_PEND:
					foreach ( str_split( $this->fragment ) as $p ) {
						$child->push( $p, false );
					} // goto DERIVER_PUSH_LAST

				case self::DERIVER_PUSH_LAST:
					$this->transfer();
					break;
			}
			return $child;
		}

		protected function filterDeriver() {
			$this->log()->debug( __METHOD__ . ' must be overrided.' );
		}

		protected function getDebugLocation() {
			$debug = clone $this->location;
			$debug->type = get_class( $this );
			$debug->done = $this->complete;
			return "\t#" . json_encode( $debug ) . "\n" . implode( '', $this->comments );
		}

		protected function log() {
			return $this->log;
		}

		protected function getFragmentLog() {
			return "({$this->fragment}[{$this->fresh}])";
		}

		private function transfer() {
			$status = $this->current->push( $this->fresh, $this->space );
			if ( self::PUSH_CONTINUE !== $status ) {
				$this->previous = $this->current;
				$this->current = null;
				if ( !$this->ending ) {
					$status = self::PUSH_OVERFLOW === $status ? $this->push( $this->fresh, $this->space ) : self::PUSH_CONTINUE;
				}
				else $this->done();
			}
			return $status;
		}

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
		 * Pushed part during deriver filtering.
		 * @var string
		 */
		protected $fragment = '';

		/**
		 * Length of $fragment.
		 * @var number
		 */
		protected $length = 0;

		/**
		 * Is identifying node?
		 * @var boolean
		 */
		protected $filter = false;

		/**
		 * Is the last node?
		 * @var boolean
		 */
		protected $ending = false;

		/**
		 * Inferior nodes.
		 * @var array
		 */
		protected $children = array( );

		/**
		 * Indicate parsing finished.
		 * @var boolean
		 */
		private $complete = false;

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
		 * Superior node.
		 * @var \atc\ast
		 */
		private $parent;

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
		 * Log tool.
		 * @var type
		 */
		private $log;

		/**
		 * Comments.
		 * @var array
		 */
		private $comments = array( );

	}

}
