<?php
namespace atc\ast {

	class body extends \atc\ast {

		const FALLBACK = 'part\dirty'; ///< For mismatched case.

		public function __toString() {
			return implode( "\n", $this->children );
		}

		protected function filterDeriver() {
			if ( $this->length ) {
				$type = static::FALLBACK;
				$more = preg_match( '/\w/', $this->fresh );
				foreach ( $this->options as $option => $length ) {
					if ( !$more ) {
						if ( $this->fragment === $option ) {
							$type = "head\\_$option";
							break;
						}
					}
					elseif ( ($this->length < $length) && (substr( $option, 0, $this->length ) === $this->fragment) ) return;
					unset( $this->options[$option] );
				}

				$this->filter = false;
				$this->options = null;
				$this->children[] = $this->appendChild( $type );
			}
			else {
				$this->options = static::$prefixes;
			}
		}

		/**
		 * Possible prefixes with their length.
		 * @var array
		 */
		protected static $prefixes = array( );

		/**
		 * Possible key words.
		 * @var array
		 */
		private $options;

	}

}
