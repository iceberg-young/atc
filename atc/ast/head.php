<?php
namespace atc\ast {

	class head extends \atc\ast {

		protected function filterDeriver( $fragment ) {
			do {
				if ( !isset( static::$patterns[$this->cursor] ) ) return false;
				$pattern = static::$patterns[$this->cursor++];
				if ( preg_match( $pattern['trait'], $fragment ) ) {
					if ( isset( $pattern['build'] ) ) {
						return $this->{$pattern['build']}( $fragment );
					}
					else return true;
				}
			} while ( isset( $pattern['optional'] ) );
			trigger_error( "unexpected $fragment", E_USER_ERROR );
		}

		/**
		 * Possible patterns.
		 * @var array
		 */
		protected static $patterns = array( );

		/**
		 * Index of current pattern.
		 * @var number
		 */
		private $cursor = 0;

	}

}
