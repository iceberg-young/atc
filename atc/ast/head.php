<?php
namespace atc\ast {

	class head extends \atc\ast {

		protected function filterDeriver( $fragment ) {
			$deriver = get_called_class();
			if ( !isset( self::$pattern_amounts[$deriver] ) ) {
				self::$pattern_amounts[$deriver] = count( static::$patterns );
			}
			do {
				if ( !isset( static::$patterns[$this->cursor] ) ) return false;
				$pattern = static::$patterns[$this->cursor++];
				if ( preg_match( $pattern['trait'], $fragment ) ) {
					if ( self::$pattern_amounts[$deriver] <= $this->cursor ) $this->markEnding();
					if ( isset( $pattern['build'] ) ) return $this->{$pattern['build']}( $fragment );
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
		 * Amount of patterns.
		 * @var array
		 */
		private static $pattern_amounts = array( );

		/**
		 * Index of current pattern.
		 * @var number
		 */
		private $cursor = 0;

	}

}
