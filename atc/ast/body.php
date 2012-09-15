<?php
namespace atc\ast {

	abstract class body extends \atc\ast {

		const FALLBACK = null; ///< For mismatched case.

		public function __toString() {
			return implode( "\n", $this->children );
		}

		protected function onIdentify() {
			if ( $this->length ) {
				$more = preg_match( '/\w/', $this->fresh );
				foreach ( $this->options as $option => $length ) {
					if ( !$more ) {
						if ( $this->fragment === $option ) {
							$type = "head\\_$option";
							break;
						}
					}
					elseif ( ($this->length < $length) && (substr( $option, 0, $this->length ) === $this->fragment) ) return parent::PUSH_CONTINUE;
					unset( $this->options[$option] );
				}
				if ( !(isset( $type ) || ($type = static::FALLBACK)) ) {
					$fragment = $this->getFragmentLog();
					die( $this->log->error( "$fragment isn't an option of child node." ) );
				}

				$this->options = null;
				$this->children[] = $this->appendChild( $type );
				return parent::PUSH_COMPLETE;
			}
			else $this->options = static::$prefixes;
			return parent::PUSH_CONTINUE;
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
