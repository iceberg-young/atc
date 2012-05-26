<?php
namespace atc\ast {

	class body extends \atc\ast {

		const FALLBACK = 'error'; ///< For mismatched case.

		public function __toString() {
			return implode( "\n", $this->children );
		}

		protected function filterDeriver( $fragment ) {
			if ( null === $this->options ) {
				$this->options = static::$prefixes;
			}
			$type = static::FALLBACK;
			$fragsize = strlen( $fragment );
			foreach ( $this->options as $option => $length ) {
				if ( $fragsize <= $length ) {
					if ( substr( $option, 0, $fragsize ) === $fragment ) return;
				}
				elseif ( preg_match( "/$option\W/", $fragment ) ) {
					$type = "head\\_$option";
					break;
				}
				unset( $this->options[$option] );
			}
			$this->children[] = $this->createDeriver( $type );
			$this->options = null;
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
