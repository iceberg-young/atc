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
					if (!$more) {
						if ($this->fragment === $option) {
							$type = "head\\_$option";
							break;
						}
					}
					elseif ( ($this->length < $length) && (substr( $option, 0, $this->length ) === $this->fragment) ) {
						return \atc\ast::FILTER_CONTINUE;
					}
					unset( $this->options[$option] );
				}

				$this->children[] = $this->createDeriver( $type );
				$this->options = null;
				return \atc\ast::FILTER_COMPLETE;
			}
			else {
				$this->options = static::$prefixes;
				return \atc\ast::FILTER_CONTINUE;
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
