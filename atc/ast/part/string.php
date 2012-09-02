<?php
namespace atc\ast\part {

	class string extends \atc\ast\part {

		public function push( $c, $s ) {
			return $this->{$this->parser}( $c );
		}

		private function parseType( $c ) {
			$this->type = $c;
			$this->parser = 'parseContent';
			return parent::PUSH_CONTINUE;
		}

		private function parseContent( $c ) {
			if ( $this->isShallow() ) {
				if ( '`' === $this->type ) {
					$d = strpos( $this->content, '`' ) + 1;
					$this->content = substr( $this->content, $d, -$d );
				}
				$this->content = '"' . addslashes( $this->content ) . '"';
				$this->parser = 'parseSuffix';
			}
			else $this->content .= $c;
			return parent::PUSH_CONTINUE;
		}

		private function parseSuffix( $c ) {
			if ( preg_match( '/[a-z]/i', $c ) ) {
				$this->suffix .= $c;
				return parent::PUSH_CONTINUE;
			}
			else {
				$this->done();
				return parent::PUSH_OVERFLOW;
			}
		}

		/**
		 * One of TYPE_*.
		 * @var string
		 */
		private $type;

		/**
		 * Parsed suffix.
		 * @var string
		 */
		private $suffix;

		/**
		 * Current parser function name.
		 * @var string
		 */
		private $parser = 'parseType';

	}

}
