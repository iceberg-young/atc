<?php
namespace atc {

	abstract class ast {

		const UNDISTINGUISHABLE = false;

		public function __construct( builder $builder, $parent = null ) {
			$this->builder = $builder;
			$this->parent = $parent;
		}

		public function getBuilder() {
			return $this->builder;
		}

		public function getParent() {
			return $this->parent;
		}

		public function isIntact() {
			return $this->intact;
		}

		public function push( $c ) {
			if ( !$this->current ) {
				if ( $this->intact && preg_match( '/\S/', $c ) ) {
					$this->advanceFilter();
					$this->intact = false;
					$this->fragment = '';
				}
				if ( !$this->intact ) {
					$this->fragment .= $c;
					$type = $this->filterDeriver();
					if ( $type ) {
						$class = "\\atc\\ast\\$type";
						$this->current = new $class( $this->builder, $this );
						if ( $class::UNDISTINGUISHABLE ) {
							foreach ( str_split( $this->fragment ) as $p ) {
								$this->pushNode( $p );
							}
						}
						else $this->pushNode( $c );
					}
				}
			}
			else $this->pushNode( $c );
		}

		protected function advanceFilter() {
			trigger_error( __METHOD__ . ' must be overrided!', E_USER_ERROR );
		}

		protected function filterDeriver() {
			trigger_error( __METHOD__ . ' must be overrided!', E_USER_ERROR );
		}

		private function pushNode( $c ) {
			if ( $this->current->push( $c ) ) {
				$this->advanceFilter();
				$this->current = null;
				$this->intact = true;
			}
		}

		/**
		 * Pushed part during deriver filtering.
		 * @var string
		 */
		protected $fragment = '';

		/**
		 * Current node.
		 * @var \atc\ast
		 */
		protected $current;

		/**
		 * Current builder.
		 * @var \atc\misc\builder
		 */
		private $builder;

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
