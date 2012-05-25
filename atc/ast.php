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

		public function isInside() {
			return $this->builder->getLevel() >= $this->location->level;
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
					if ( $this->filterDeriver( $this->fragment ) ) return true;
				}
			}
			else $this->transfer( $c );
			return $this->ending && $this->intact;
		}

		protected function createDeriver( $type, array $args = array( ), $transfer = true, $ending = false ) {
			$this->ending = $ending;
			array_push( $args, $this->builder, $this );
			$class = new \ReflectionClass( "\\atc\\ast\\$type" );
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

		private function transfer( $c ) {
			if ( $this->current->push( $c ) ) {
				$this->current = null;
				$this->intact = true;
				$this->builder->clearLocation();
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

	}

}
