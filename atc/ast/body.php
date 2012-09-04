<?php
namespace atc\ast {

	class body extends \atc\ast {

		const FALLBACK = null; ///< For mismatched case.

		public function __toString() {
			return implode( "\n", $this->children );
		}

		protected function filterDeriver() {
			if ( $this->length ) {
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
				if ( !isset( $type ) ) {
					if ( !static::FALLBACK ) {
						$this->log()->error( "({$this->fragment}[{$this->fresh}]) isn't an option of child node." );
						die();
					}
					$type = static::FALLBACK;
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
