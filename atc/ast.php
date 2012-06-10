<?php
namespace atc {

	abstract class ast {

		const UNDISTINGUISHABLE = false;

		public function __construct( builder $builder, $parent = null ) {
			$this->builder = $builder;
			$this->parent = $parent;

			$this->location = $this->builder->getLocation();
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
			return $this->builder->getLevel() >= $this->location->level;
		}

		public function isShallow() {
			return $this->builder->getLevel() <= $this->location->level;
		}

		public function push( $c ) {
			if ( !$this->current ) {
				if ( $this->intact && preg_match( '/\S/', $c ) ) {
					$this->builder->markLocation();
					$this->intact = false;
					$this->fragment = '';
				}
				if ( !$this->intact ) {
					$this->fragment .= $c;
					$status = $this->filterDeriver( $this->fragment );
					if ( $status ) {
						$this->intact = true;
						$this->fragment = '';
						$status = null;
					}
					return $status;
				}
			}
			else return $this->transfer( $c );
		}

		public function comment( $blank ) {
			if ( $this->current ) {
				$comment = $this->current->comment( $blank );
			}
			else if ( !$blank && $this->previous ) {
				$comment = $this->previous->comment( $blank );
			}
			else {
				$comment = new ast\part\comment( $this->builder, $this );
				$this->comments[] = $comment;
			}
			return $comment;
		}

		protected function createDeriver( $type, array $args = array( ), $transfer = true ) {
			array_push( $args, $this->builder, $this );
			$class = new \ReflectionClass( "atc\\ast\\$type" );
			$this->previous = $this->current;
			$this->current = $class->newInstanceArgs( $args );
			if ( $transfer ) {
				if ( $class->getConstant( 'UNDISTINGUISHABLE' ) ) {
					foreach ( str_split( $this->fragment ) as $p ) {
						$this->transfer( $p );
					}
				}
				else $this->transfer( substr( $this->fragment, -1 ) );
			}
			return $this->current;
		}

		protected function filterDeriver( array $fragment ) {
			trigger_error( __METHOD__ . ' must be overrided!', E_USER_ERROR );
		}

		protected function getDebugLocation() {
			return "\t#" . json_encode( $this->getLocation() ) . "\n";
		}

		protected function markEnding() {
			$this->ending = true;
		}

		private function transfer( $c ) {
			$status = $this->current->push( $c );
			if ( null !== $status ) {
				$this->previous = $this->current;
				$this->current = null;
				$this->intact = true;
				$this->builder->clearLocation();
				if ( !$status ) return $this->push( $c );
				elseif ( $this->ending ) return true;
			}
		}

		/**
		 * Pushed part during deriver filtering.
		 * @var string
		 */
		private $fragment;

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
