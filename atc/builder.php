<?php
namespace atc {

	class builder {

		public function __construct() {
			$this->tree = new ast\tree();
		}

		public function parse( $path, $isEntry = true ) {
			$this->file = $path;
			$this->line = 0;
			$this->column = 0;
			$this->stack = array( );
			$this->string = false;
			$this->escaping = false;

			if ( $isEntry ) {
				$node = new ast\body\call( $this );
				$this->tree->setEntry( $node );
			}
			else {
				$node = new ast\body\file( $this );
			}

			$file = fopen( $path, 'r' );
			while ( false !== ($c = fgetc( $file )) ) {
				$this->parseLevel( $c );
				if ( "\n" === $c ) {
					++$this->line;
					$this->column = 0;
				}
				$node->push( $c );
			}
			fclose( $file );
		}

		public function getAst() {
			return $this->tree;
		}

		public function getFile() {
			return $this->file;
		}

		public function getLine() {
			return $this->line;
		}

		public function getColumn() {
			return $this->column;
		}

		public function getLevel() {
			return count( $this->stack ) + (null !== $this->top);
		}

		private function parseLevel( $c ) {
			if ( !$this->string ) {
				if ( isset( self::$brackets[$c] ) ) {
					if ( $this->top ) {
						array_push( $this->stack, $this->top );
					}
					$this->top = $c;
					$this->string = self::$brackets[$this->top] === $c;
				}
				elseif ( in_array( $c, self::$brackets ) ) {
					if ( $this->top && (self::$brackets[$this->top] === $c) ) {
						$this->top = array_pop( $this->stack );
					}
					else trigger_error( 'unbalanced', E_USER_WARNING );
				}
			}
			elseif ( !$this->escaping ) {
				if ( '\\' === $c ) $this->escaping = true;
				elseif ( $this->top === $c ) {
					$this->top = array_pop( $this->stack );
					$this->string = false;
				}
			}
			else $this->escaping = false;
		}

		/**
		 * @var ast\tree
		 */
		private $tree;

		/**
		 * Current file name.
		 * @var string
		 */
		private $file;

		/**
		 * Cyrrent line number.
		 * @var number
		 */
		private $line;

		/**
		 * Current column number
		 * @var number
		 */
		private $column;

		/**
		 * Nearest open bracket.
		 * @var string
		 */
		private $top;

		/**
		 * Bracket stack.
		 * @var array
		 */
		private $stack;

		/**
		 * Is parsing string.
		 * @var boolean
		 */
		private $string;

		/**
		 * Is escaping in string.
		 * @var boolean
		 */
		private $escaping;

		/**
		 * Bracket pairs.
		 * @var array
		 */
		private static $brackets = array(
			'(' => ')',
			'[' => ']',
			'{' => '}',
			'"' => '"',
			'\'' => '\'',
		);

	}

}
