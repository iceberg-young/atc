<?php
namespace atc\ast\part {

	class string extends \atc\ast {

		public function __construct( $type, \atc\builder $builder, $parent = null ) {
			parent::__construct( $builder, $parent );
			$this->escapable = '"' === $type;
		}

		public function __toString() {
			return "**{$this->content}**" . json_encode( $this->getSource() );
		}

		public function push( $c ) {
			if ( $this->isInside() ) {
				if ( $this->escapable ) {
					if ( '\\' === $c ) {
						if ( $this->escaping ) $this->content .= '\\';
						$this->escaping = !$this->escaping;
					}
					elseif ( $this->escaping ) {
						if ( isset( self::$table[$c] ) ) {
							$this->content .= self::$table[$c];
						}
						else {
							trigger_error( "cannot escape '$c'", E_USER_NOTICE );
							$this->content .= "\\$c";
						}
						$this->escaping = false;
					}
				}
				else $this->content .= $c;
			}
			else return true;
		}

		/**
		 * Is parsing " string.
		 * @var boolean
		 */
		private $escapable;

		/**
		 * Is escaping in string.
		 * @var boolean
		 */
		private $escaping;

		/**
		 * Partial content during escaping.
		 * @var boolean
		 */
		private $escaped;

		/**
		 * Parsed content.
		 * @var string
		 */
		private $content;

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
