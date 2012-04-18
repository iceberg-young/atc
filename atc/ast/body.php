<?php
namespace atc\ast {

	class body extends \atc\ast {

		public function __toString() {
			return implode( "\n", $this->children );
		}

		protected function advanceFilter() {
			if ( $this->current ) {
				$this->children[] = $this->current;
			}
			$this->options = static::$prefixes;
		}

		protected function filterDeriver() {
			$fragsize = strlen( $this->fragment );
			foreach ( $this->options as $option => $length ) {
				if ( $fragsize <= $length ) {
					if ( substr( $option, 0, $fragsize ) === $this->fragment ) {
						return;
					}
				}
				elseif ( preg_match( "/$option\W/", $this->fragment ) ) {
					return "head\\_$option";
				}
				unset( $this->options[$option] );
			}
			return static::$fallback;
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
