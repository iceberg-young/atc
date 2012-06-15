<?php
namespace atc\ast {

	class body extends \atc\ast {

		const FALLBACK = 'part\dirty'; ///< For mismatched case.

		public function __toString() {
			return implode( "\n", $this->children );
		}

		protected function filterDeriver( $c, $s ) {
			if ( null === $this->options ) {
				$this->options = static::$prefixes;
			}
			if ( $this->length ) {
				$type = static::FALLBACK;
				foreach ( $this->options as $option => $length ) {
					if ( $this->length < $length ) {
						if ( substr( $option, 0, $this->length ) === $this->fragment ) return;
					}
					elseif ( preg_match( '/\W/', $c ) && ($this->fragment === $option) ) {
						$type = "head\\_$option";
						break;
					}
					unset( $this->options[$option] );
				}

				$node = $this->createDeriver( $type );
				if ( $node::UNDISTINGUISHABLE ) {
					foreach ( str_split( $this->fragment ) as $p ) {
						$node->push( $p, false );
					}
				}
				$node->push( $c, $s );
				$this->children[] = $node;
				$this->options = null;
			}
		}

		/**
		 * Possible prefixes with their length.
		 * @var array
		 */
		protected static $prefixes = array( );

		/**
		 * Inferior nodes.
		 * @var array
		 */
		private $children = array( );

		/**
		 * Possible key words.
		 * @var array
		 */
		private $options;

	}

}
