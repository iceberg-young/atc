<?php
namespace atc {

	class builder {

		public function __construct( $path ) {
			$this->log = new log( $this, __CLASS__ );

			switch ( strrchr( $path, '.' ) ) {
				case '.ate':
					$this->node = new ast\body\_call( $this );
					break;
				case '.atd':
					$this->node = new ast\body\file( $this );
					break;
				default:
					die( "I don't know how to deal with $path." );
			}
			$this->path = $path;
		}

		public function parse() {
			// Source location.
			$this->row = 0;
			$this->column = -1;

			// Bracket level.
			$this->stack = array( );
			$this->escaping = false;

			// Invisible literals.
			$this->space = false;
			$this->blank = true;

			$this->setParser( self::PARSE_BRACKET );

			$file = fopen( $this->path, 'r' );
			while ( false !== ($c = fgetc( $file )) ) {
				if ( "\n" === $c ) {
					++$this->row;
					$this->column = -1;
					$this->blank = true;
				}
				else ++$this->column;

				$this->{$this->parser}( $c );
				$s = self::LAST_SPACE >= ord( $c );
				call_user_func( $this->pusher, $c, $s );

				$this->space = $s;
				$this->blank = $this->blank && $this->space;
			}
			fclose( $file );
		}

		public function getNode() {
			return $this->node;
		}

		public function getLevel() {
			return count( $this->stack );
		}

		public function getLocation() {
			return array(
				'path' => $this->path,
				'row' => $this->row,
				'column' => $this->column,
				'level' => $this->getLevel(),
			);
		}

		public function markLocation() {
			$this->location = $this->getLocation();
		}

		public function pickLocation() {
			return $this->location;
		}

		private function setParser( $parser ) {
			switch ( $parser ) {
				case self::PARSE_BRACKET:
					$this->pusher = array( $this, 'trim' );
					break;

				case self::PARSE_ESCAPABLE:
				case self::PARSE_RAW_STRING:
				case self::PARSE_RAW_ENDING:
					$this->pusher = array( $this->node, 'push' );
					break;

				case self::PARSE_COMMENT:
					if ( !($this->comment && $this->blank && $this->comment->more( $this->row )) ) {
						$this->markLocation();
						$this->comment = $this->node->comment( $this->blank );
					}
					$this->pusher = array( $this->comment, 'push' );
					$parser = self::PARSE_TERMINAL;
					break;

				case self::PARSE_TERMINAL:
				default:
					$this->log->debug( "Unexpected parser ($parser)" );
			}
			$this->parser = $parser;
		}

		const PARSE_BRACKET = 'parseBracket';

		private function parseBracket( $c ) {
			if ( isset( self::$brackets[$c] ) ) {
				$this->stack[] = $c;
				if ( isset( self::$literals[$c] ) ) {
					$this->setParser( self::$literals[$c] );
					if ( '`' === $c ) $this->delimiters = array( );
				}
			}
			else $this->parseTerminal( $c );
		}

		const PARSE_RAW_STRING = 'parseRawString';

		private function parseRawString( $c ) {
			if ( end( $this->delimiters ) !== '`' ) $this->delimiters[] = $c;
			elseif ( '`' === $c ) {
				reset( $this->delimiters );
				$this->setParser( self::PARSE_RAW_ENDING );
			}
		}

		const PARSE_RAW_ENDING = 'parseRawEnding';

		private function parseRawEnding( $c ) {
			$d = each( $this->delimiters );
			$d[1] !== $c ? reset( $this->delimiters ) : $this->parseTerminal( $c );
		}

		const PARSE_ESCAPABLE = 'parseEscapable';

		private function parseEscapable( $c ) {
			if ( $this->escaping ) $this->escaping = false;
			elseif ( '\\' === $c ) $this->escaping = true;
			else $this->parseTerminal( $c );
		}

		const PARSE_COMMENT = 'parseComment';
		const PARSE_TERMINAL = 'parseTerminal';

		private function parseTerminal( $c ) {
			$top = end( $this->stack );
			if ( false === $top ) return;
			if ( self::$brackets[$top] === $c ) {
				array_pop( $this->stack );
				$this->setParser( self::PARSE_BRACKET );
			}
		}

		private function trim( $c, $s ) {
			if ( !($s && $this->space) ) $this->node->push( $c, $s );
		}

		/**
		 * Log tool.
		 * @var log
		 */
		private $log;

		/**
		 * Current parser function name.
		 * @var string
		 */
		private $parser;

		/**
		 * Method of pushing character to node.
		 * @var callable
		 */
		private $pusher;

		/**
		 * @var ast
		 */
		private $node;

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
		 * Comment.
		 * @var part\comment
		 */
		private $comment;

		/**
		 * Is an invisible character?
		 * @var boolean
		 */
		private $space;

		/**
		 * Is a blank line?
		 * @var boolean
		 */
		private $blank;

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
			'`' => self::PARSE_RAW_STRING,
			'"' => self::PARSE_ESCAPABLE,
			"'" => self::PARSE_ESCAPABLE,
			'#' => self::PARSE_COMMENT,
		);

		const LAST_SPACE = 32; // ord( ' ' )

	}

}
