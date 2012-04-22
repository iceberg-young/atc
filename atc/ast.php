<?php
namespace atc {

	abstract class ast {

		const UNDISTINGUISHABLE = false;

		public function __construct( builder $builder, $parent = null ) {
			$this->builder = $builder;
			$this->source = $builder->popSource();
			$this->parent = $parent;
		}

		public function getBuilder() {
			return $this->builder;
		}

		public function getSource() {
			return $this->source;
		}

		public function getParent() {
			return $this->parent;
		}

		public function isIntact() {
			return $this->intact;
		}

		public function isInside() {
			return $this->builder->getLevel() >= $this->source->level;
		}

		public function push( $c ) {
			if ( !$this->current ) {
				if ( $this->intact && preg_match( '/\S/', $c ) ) {
					$this->builder->pushSource();
					$this->intact = false;
					$this->fragment = '';
				}
				if ( !$this->intact ) {
					$this->fragment .= $c;
					$this->filterDeriver( $this->fragment );
				}
			}
			else $this->transfer( $c );
		}

		protected function createDeriver( $type ) {
			$class = "\\atc\\ast\\$type";
			$this->current = new $class( $this->builder, $this );
			if ( $class::UNDISTINGUISHABLE ) {
				foreach ( str_split( $this->fragment ) as $p ) {
					$this->transfer( $p );
				}
			}
			else $this->transfer( substr( $this->fragment, -1 ) );
			return $this->current;
		}

		protected function filterDeriver( $fragment ) {
			trigger_error( __METHOD__ . ' must be overrided!', E_USER_ERROR );
		}

		private function transfer( $c ) {
			if ( $this->current->push( $c ) ) {
				$this->current = null;
				$this->intact = true;
			}
		}

		/**
		 * Pushed part during deriver filtering.
		 * @var string
		 */
		private $fragment = '';

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
		 * Source location of the beginning.
		 * @var object
		 */
		private $source;

		/**
		 * Superior node.
		 * @var \atc\ast
		 */
		private $parent;

		/**
		 * Is constructing node.
		 * @var boolean
		 */
		private $intact = true;

	}

}
