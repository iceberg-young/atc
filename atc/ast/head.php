<?php
namespace atc\ast {

	class head extends \atc\ast {

		protected function filterDeriver() {
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
						$match = $trait === $this->fresh;
					}
					elseif ( '#' === $trait{0} ) {
						$match = preg_match( $trait, $this->fresh );
					}
					elseif ( $this->length === $length ) {
						$match = preg_match( '/\W/', $this->fresh ) && ($pattern['trait'] === $this->fragment);
					}
					else return \atc\ast::FILTER_CONTINUE;
				}
				else $match = true;

				if ( $match ) {
					if ( $count === $this->cursor ) $this->markEnding();
					if ( isset( $pattern['build'] ) ) {
						$this->{$pattern['build']}();
						return \atc\ast::FILTER_COMPLETE;
					}
					else return \atc\ast::FILTER_TERMINAL;
				}
				elseif ( !isset( $pattern['optional'] ) ) {
					trigger_error( "unexpected {$this->fragment}({$this->fresh})", E_USER_ERROR );
				}
			}
			trigger_error( "out of patterns", E_USER_ERROR );
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
