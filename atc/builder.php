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

			if ( $isEntry ) {
				$node = new ast\body\call( $this );
				$this->tree->setEntry( $node );
			}
			else {
				$node = new ast\body\file( $this );
			}

			$file = fopen( $path, 'r' );
			while ( false !== ($c = fgetc( $file )) ) {
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

	}

}
