<?php
namespace atc\ast\part {

	class string extends \atc\ast {

		public function __construct( \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->parser = 'parseType';
		}

		public function __toString() {
			return $this->content . $this->getDebugLocation();
		}

		public function push( $c ) {
			return $this->{$this->parser}( $c );
		}

		private function parseType( $c ) {
			$this->type = $c;
			$this->parser = 'parseContent';
			return parent::PUSH_CONTINUE;
		}

		private function parseContent( $c ) {
			if ( !$this->isDeep() ) {
				if ( '`' === $this->type ) {
					$d = strpos( $this->content, '`' ) + 1;
					$this->content = substr( $this->content, $d, -$d );
				}
				else {
					// escaping?
				}
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
			else return parent::PUSH_OVERFLOW;
		}

		/**
		 * One of TYPE_*.
		 * @var string
		 */
		private $type;

		/**
		 * Parsed content.
		 * @var string
		 */
		private $content;

		/**
		 * Parsed suffix.
		 * @var string
		 */
		private $suffix;

		/**
		 * Escape lookup table.
		 * @var array
		 */
		private static $table = array(
			'"' => '"',
			'n' => "\n",
		);

	}

}
