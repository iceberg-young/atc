<?php
namespace atc\ast {

	class head extends \atc\ast {

		protected function filterDeriver( $c, $s ) {
			$deriver = get_called_class();
			if ( !isset( self::$pattern_amounts[$deriver] ) ) {
				self::$pattern_amounts[$deriver] = count( static::$patterns );
			}
			$count = self::$pattern_amounts[$deriver];
			while ( $count > $this->cursor ) {
				$pattern = static::$patterns[$this->cursor++];
				if ( isset( $pattern['trait'] ) ) {
					$trait = $pattern['trait'];
					$length = strlen( $trait );

					if ( 1 === $length ) {
						$match = $trait === $c;
					}
					elseif ( '#' === $trait{0} ) {
						$match = preg_match( $trait, $c );
					}
					elseif ( $this->length === $length ) {
						$match = preg_match( '/\W/', $c ) && ($pattern['trait'] === $this->fragment);
					}
					else return;
				}
				else $match = true;

				if ( $match ) {
					if ( $count === $this->cursor ) $this->markEnding();
					return isset( $pattern['build'] ) ? $this->{$pattern['build']}( $c, $s ) : true;
				}
				elseif ( !isset( $pattern['optional'] ) ) {
					trigger_error( "unexpected {$this->fragment}($c)", E_USER_ERROR );
				}
			}
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
