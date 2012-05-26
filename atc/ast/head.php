<?php
namespace atc\ast {

	class head extends \atc\ast {

		protected function filterDeriver( $fragment ) {
			do {
				$entry = each( static::$patterns );
				if ( !$entry ) {
					reset( static::$patterns );
					return false;
				}
				$pattern = $entry['value'];
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

	}

}
