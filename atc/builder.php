<?php
namespace atc {

	class builder {

		public function __construct() {
			$this->tree = new ast\tree();
		}

		public function parse( $path ) {
			switch ( strrchr( $path, '.' ) ) {
				case '.ate':
					$node = new ast\body\call( $this );
					$this->tree->setEntry( $node );
					break;
				case '.atd':
					$node = new ast\body\file( $this );
					break;
				default:
					die( "I don't know how to deal with $path." );
			}

			$this->parser = 'parseBracket';

			// Source location.
			$this->path = $path;
			$this->row = 0;
			$this->column = -1;

			// Bracket level.
			$this->stack = array( );
			$this->escaping = false;

			$file = fopen( $path, 'r' );
			while ( false !== ($c = fgetc( $file )) ) {
				if ( "\n" === $c ) {
					++$this->row;
					$this->column = -1;
				}
				else ++$this->column;
				$this->{$this->parser}( $c );
				$node->push( $c );
			}
			fclose( $file );
		}

		public function getAst() {
			return $this->tree;
		}

		public function getLevel() {
			return count( $this->stack );
		}

		public function getLocation() {
			return $this->location;
		}

		public function markLocation() {
			$this->location = (object) array(
				'path' => $this->path,
				'row' => $this->row,
				'column' => $this->column,
				'level' => $this->getLevel(),
			);
		}

		public function clearLocation() {
			$this->location = null;
		}

		private function parseBracket( $c ) {
			if ( isset( self::$brackets[$c] ) ) {
				$this->stack[] = $c;
				if ( isset( self::$literals[$c] ) ) {
					$this->parser = self::$literals[$c];
					if ( '`' === $c ) $this->delimiters = array( );
				}
			}
			else $this->parseTerminal( $c );
		}

		private function parseRawString( $c ) {
			if ( end( $this->delimiters ) !== '`' ) $this->delimiters[] = $c;
			elseif ( '`' === $c ) {
				reset( $this->delimiters );
				$this->parser = 'parseRawEnding';
			}
		}

		private function parseRawEnding( $c ) {
			$d = each( $this->delimiters );
			$d[1] !== $c ? reset( $this->delimiters ) : $this->parseTerminal( $c );
		}

		private function parseEscapable( $c ) {
			if ( $this->escaping ) $this->escaping = false;
			elseif ( '\\' === $c ) $this->escaping = true;
			else $this->parseTerminal( $c );
		}

		private function parseTerminal( $c ) {
			$top = end( $this->stack );
			if ( false === $top ) return;
			if ( self::$brackets[$top] === $c ) {
				array_pop( $this->stack );
				$this->parser = 'parseBracket';
			}
		}

		/**
		 * Current parser function name.
		 * @var string
		 */
		private $parser;

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
		 * Source location snapshot.
		 * @var object
		 */
		private $location;

		/**
		 * Bracket stack.
		 * @var array
		 */
		private $stack;

		/**
		 * Is escaping a literal?
		 * @var boolean
		 */
		private $escaping;

		/**
		 * Delimiters of raw string.
		 * @var array
		 */
		private $delimiters;

		/**
		 * Bracket pairs.
		 * @var array
		 */
		private static $brackets = array(
			'(' => ')',
			'[' => ']',
			'{' => '}',
			'`' => '`',
			'"' => '"',
			"'" => "'",
			'#' => "\n",
		);

		/**
		 * Literals parsers.
		 * @var array
		 */
		private static $literals = array(
			'`' => 'parseRawString',
			'"' => 'parseEscapable',
			"'" => 'parseEscapable',
			'#' => "parseTerminal",
		);

	}

}
