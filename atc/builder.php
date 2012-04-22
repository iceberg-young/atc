<?php
namespace atc {

	class builder {

		public function __construct() {
			$this->tree = new ast\tree();
		}

		public function parse( $path, $isEntry = true ) {
			// Source location.
			$this->path = $path;
			$this->row = 0;
			$this->column = -1;
			$this->sources = array( );

			// Bracket level.
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
					++$this->row;
					$this->column = -1;
				}
				else ++$this->column;
				$node->push( $c );
			}
			fclose( $file );
		}

		public function getAst() {
			return $this->tree;
		}

		public function getLevel() {
			return count( $this->stack ) + (null !== $this->top);
		}

		public function getSource() {
			return (object) array(
				'path' => $this->path,
				'row' => $this->row,
				'column' => $this->column,
				'level' => $this->getLevel(),
			);
		}

		public function pushSource() {
			array_push( $this->sources, $this->getSource() );
		}

		public function popSource() {
			return array_pop( $this->sources );
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
				if ( '\\' === $c && '"' === $this->top ) $this->escaping = true;
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
		 * Current file path.
		 * @var string
		 */
		private $path;

		/**
		 * Cyrrent row number.
		 * @var number
		 */
		private $row;

		/**
		 * Current column number
		 * @var number
		 */
		private $column;

		/**
		 * Source location snapshots.
		 * @var array
		 */
		private $sources;

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
			"'" => "'",
		);

	}

}
