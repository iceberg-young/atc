<?php
namespace atc\ast {

	class head extends \atc\ast {

		protected function filterDeriver( $fragment ) {
			do {
				$pattern = static::$patterns[$this->cursor++];
				if ( preg_match( $pattern['trait'], $fragment ) ) {
					if ( isset( $pattern['build'] ) ) {
						$method = $pattern['build'];
						$this->$method( $fragment );
						return;
					}
					else return true;
				}
			} while ( isset( $pattern['optional'] ) );
			trigger_error( "unexpected $fragment", E_USER_ERROR );
		}

		private $cursor = 0;

	}

}
