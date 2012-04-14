<?php
namespace atc {

	abstract class ast {

		public function __construct( builder $builder ) {
			$this->builder = $builder;
		}

		public function __toString() {
			return implode( "\n", $this->nodes );
		}

		public function push( $c ) {
			if ( !$this->node ) {
				$ast = $this->select( $c );
				if ( $ast ) {
					$class = '\\atc\\ast\\' . (true === $ast ? static::$fallback : $ast);
					$this->node = new $class( $this->builder, $this->segment );
					$this->segment = '';
					$this->length = 0;
					$this->state = false;
				}
			}
			elseif ( $this->node->push( $c ) ) {
				$this->nodes[] = $this->node;
				$this->node = null;
			}
		}

		protected function select( $c ) {
			if ( !$this->state ) {
				$this->state = preg_match( '/\S/', $c );
			}
			if ( $this->state ) {
				++$this->length;
				$this->segment .= $c;
				$miss = true;
				foreach ( static::$prefixes as $prefix => $length ) {
					if ( $this->length <= $length ) {
						if ( substr( $prefix, 0, $this->length ) === $this->segment ) {
							unset( $miss );
							break;
						}
					}
					elseif ( preg_match( "/$prefix\W/", $this->segment ) ) {
						return "prefix\\_$prefix";
					}
				}
			}
			return $this->state && isset( $miss );
		}

		/**
		 * Current builder.
		 * @var \atc\misc\builder
		 */
		protected $builder;

		/**
		 * Added statements.
		 * @var array
		 */
		protected $nodes = array( );

		/**
		 * Current statement.
		 * @var \atc\ast\statement
		 */
		private $node;

		/**
		 * Pushed part during selecting.
		 * @var string
		 */
		private $segment = '';
		private $length = 0;

		/**
		 * Is selecting.
		 * @var boolean
		 */
		private $state;

	}

}
