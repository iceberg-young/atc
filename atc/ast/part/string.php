<?php
namespace atc\ast\part {

	class string extends \atc\ast {

		public function __construct( $type, \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->type = $type;
			$this->parser = 'parseContent';
		}

		public function __toString() {
			return "**{$this->content}**" . json_encode( $this->getLocation() );
		}

		public function push( $c ) {
			return $this->{$this->parser}( $c );
		}

		private function parseContent( $c ) {
			if ( !$this->isInside() ) {
				if ( '`' === $this->type ) {
					$d = strpos( $this->content, '`' );
					$this->content = substr( $this->content, $d, -$d );
				}
				else {
					// escaping?
				}
				$this->parser = 'parseSuffix';
			}
			else $this->content .= $c;
		}

		private function parseSuffix( $c ) {
			if ( preg_match( '/[a-z]/i', $c ) ) $this->suffix .= $c;
			else return false;
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
