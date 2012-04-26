<?php
namespace atc\ast\part {

	class name extends \atc\ast {

		public function __toString() {
			return "|{$this->content}|" . json_encode( $this->getSource() );
		}

		public function push( $c ) {
			if ( preg_match( '#\w#', $c ) ) {
				$this->content .= $c;
			}
			else return true;
		}

		/**
		 * Parsed content.
		 * @var string
		 */
		private $content;

	}

}
