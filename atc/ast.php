<?php
namespace atc {

	abstract class ast {

		public function __construct( builder $builder, $parent = null ) {
			$this->builder = $builder;
			$this->parent = $parent;
		}

		public function __toString() {
			return implode( "\n", $this->children );
		}

		public function getParent() {
			return $this->parent;
		}

		public function isIntact() {
			return $this->intact;
		}

		public function push( $c ) {
			if ( !$this->node ) {
				$ast = $this->select( $c );
				if ( $ast ) {
					$class = '\\atc\\ast\\' . (true === $ast ? static::$fallback : $ast);
					$this->node = new $class( $this->builder, $this );
					if ( true === $ast ) {
						foreach ( str_split( $this->segment ) as $p ) {
							$this->pushNode( $p );
						}
					}
					else $this->pushNode( $c );
					$this->segment = '';
					$this->length = 0;
				}
			}
			else $this->pushNode( $c );
		}

		protected function select( $c ) {
			if ( $this->intact ) {
				$this->intact = !preg_match( '/\S/', $c );
			}
			if ( !$this->intact ) {
				++$this->length;
				$this->segment .= $c;
				foreach ( static::$prefixes as $prefix => $length ) {
					if ( $this->length <= $length ) {
						if ( substr( $prefix, 0, $this->length ) === $this->segment ) {
							$match = true;
							break;
						}
					}
					elseif ( preg_match( "/$prefix\W/", $this->segment ) ) {
						return "prefix\\_$prefix";
					}
				}
			}
			return !($this->intact || isset( $match ));
		}

		private function pushNode( $c ) {
			if ( $this->node->push( $c ) ) {
				$this->children[] = $this->node;
				$this->intact = true;
				$this->node = null;
			}
		}

		/**
		 * Current builder.
		 * @var \atc\misc\builder
		 */
		protected $builder;

		/**
		 * Superior node.
		 * @var \atc\ast
		 */
		protected $parent;

		/**
		 * Inferior nodes.
		 * @var array
		 */
		protected $children = array( );

		/**
		 * Is constructing node.
		 * @var boolean
		 */
		protected $intact = true;

		/**
		 * Current statement.
		 * @var \atc\ast
		 */
		private $node;

		/**
		 * Pushed part during selecting.
		 * @var string
		 */
		private $segment = '';
		private $length = 0;

	}

}
