<?php
namespace atc\ast {

	class body extends \atc\ast {

		protected function select() {
			foreach ( $this->options as $option => $length ) {
				if ( $this->length <= $length ) {
					if ( substr( $option, 0, $this->length ) === $this->segment ) {
						return;
					}
				}
				elseif ( preg_match( "/$option\W/", $this->segment ) ) {
					return "head\\_$option";
				}
				unset( $this->options[$option] );
			}
			return true;
		}

		protected function advance() {
			$this->options = static::$prefixes;
		}

		/**
		 * Possible key words.
		 * @var array
		 */
		private $options;

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

	}

}
