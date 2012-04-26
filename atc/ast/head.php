<?php
namespace atc\ast {

	class head extends \atc\ast {

		protected function filterDeriver( $fragment ) {
			do {
				$pattern = static::$patterns[$this->cursor++];
				if ( in_array( $fragment, $pattern['trait'] ) ) {
					if ( isset( $pattern['build'] ) ) {
						$method = $pattern['build'];
						$this->$method( $fragment );
						return;
					}
					else return true;
				}
			} while ( isset( $pattern['optional'] ) );
			trigger_error( 'unexpected', E_USER_ERROR );
		}

		private $cursor = 0;

	}

}
