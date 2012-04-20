<?php
namespace atc\ast {

	class body extends \atc\ast {

		public function __toString() {
			return implode( "\n", $this->children );
		}

		protected function filterDeriver( $fragment ) {
			if ( null === $this->options ) {
				$this->options = static::$prefixes;
			}
			$type = static::$fallback;
			$fragsize = strlen( $fragment );
			foreach ( $this->options as $option => $length ) {
				if ( $fragsize <= $length ) {
					if ( substr( $option, 0, $fragsize ) === $fragment ) {
						return;
					}
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
		 * Possible prefixes with lengths.
		 * @var array
		 */
		protected static $prefixes = array( );

		/**
		 * For mismatched case.
		 * @var string
		 */
		protected static $fallback = 'error';

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
