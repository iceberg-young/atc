<?php
namespace atc {

	abstract class ast {

		public function __construct( builder $builder, $parent = null ) {
			$this->builder = $builder;
			$this->parent = $parent;
			$this->advance();
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
				$type = $this->findNode( $c );
				if ( $type ) {
					$class = '\\atc\\ast\\' . (true !== $type ? $type : static::$fallback);
					$this->node = new $class( $this->builder, $this );
					if ( true === $type ) {
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

		private function findNode( $c ) {
			if ( $this->intact ) {
				$this->intact = !preg_match( '/\S/', $c );
			}
			if ( !$this->intact ) {
				++$this->length;
				$this->segment .= $c;
				return $this->select();
			}
		}

		private function pushNode( $c ) {
			if ( $this->node->push( $c ) ) {
				$this->children[] = $this->node;
				$this->intact = true;
				$this->node = null;
				$this->advance();
			}
		}

		abstract protected function select();

		abstract protected function advance();

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
		protected $segment = '';
		protected $length = 0;

	}

}
