<?php
namespace atc\ast {

	class head extends \atc\ast {

		public function __get( $name ) {
			return @$this->children[$name];
		}

		protected function filterDeriver() {
			$deriver = get_called_class();
			if ( !isset( self::$pattern_amounts[$deriver] ) ) {
				self::$pattern_amounts[$deriver] = count( static::$patterns );
			}
			$count = self::$pattern_amounts[$deriver];
			while ( $count > $this->cursor ) {
				$pattern = &static::$patterns[$this->cursor];
				$this->completePattern( $deriver, $pattern );

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
					else return;
				}
				else $match = true;

				if ( $count === ++$this->cursor ) $this->ending = true;

				if ( $match ) {
					$this->filter = false;
					if ( isset( $pattern['build'] ) ) {
						$this->children[$pattern['label']] = $this->{$pattern['build']}();
					}
					elseif ( isset( $pattern['label'] ) ) {
						$this->children[$pattern['label']] = $this->fresh;
					}
					return;
				}
				elseif ( !isset( $pattern['optional'] ) ) {
					trigger_error( "unexpected {$this->fragment}({$this->fresh}) of $deriver", E_USER_ERROR );
				}
			}
			trigger_error( "$deriver out of patterns for {$this->fragment}({$this->fresh})", E_USER_ERROR );
		}

		protected function completePattern( $deriver, &$pattern ) {
			if ( isset( $pattern['template'] ) ) {
				$name = $pattern['template'];
				if ( !isset( $pattern['trait'] ) ) {
					$trait = $deriver . '::' . strtoupper( $name ) . '_TRAIT';
					if ( defined( $trait ) ) {
						$pattern['trait'] = constant( $trait );
					}
				}
				if ( !isset( $pattern['build'] ) ) {
					$build = 'create' . ucfirst( $name );
					if ( method_exists( $deriver, $build ) ) {
						$pattern['build'] = $build;
					}
				}
				if ( !isset( $pattern['label'] ) ) {
					$pattern['label'] = $name;
				}
			}
		}

		protected function createPath() {
			return $this->appendChild( 'part\string' );
		}

		const NAME_TRAIT = '#[a-z_]#i';

		protected function createName() {
			return $this->appendChild( 'part\name', false );
		}

		const LINK_TRAIT = '#[a-z_]#i';

		protected function createLink() {
			return $this->appendChild( 'part\name', true );
		}

		const BODY_TRAIT = '[';

		protected function createBody() {
			return $this->appendChild( 'part\block', 'body\_call' );
		}

		protected function createTerm() {
			return $this->appendChild( 'part\before', 'part\dirty' );
		}

		protected function createDeclare() {
			return $this->appendChild( 'head\_of' );
		}

		const ACCESS_TRAIT = '#[+-]#';
		const LOCATE_TRAIT = '#[.*/=]#';
		const STATIC_TRAIT = '.';
		const VIRTUAL_TRAIT = '*';
		const FINAL_TRAIT = '/';

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
