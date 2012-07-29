<?php
namespace atc\ast\part {

	class comment extends \atc\ast {

		public function __toString() {
			return "# $this->content" . $this->getDebugLocation();
		}

		public function push( $c ) {
			$this->prefix ? $this->prefix = false : $this->content .= $c;
			return parent::PUSH_CONTINUE;
		}

		public function more( $row ) {
			if ( $this->getLocation()->row + $this->lines >= $row ) {
				$this->content .= PHP_EOL;
				$this->prefix = true;
				++$this->lines;
			}
			return $this->prefix;
		}

		/**
		 * Parsed content.
		 * @var string
		 */
		private $content;

		/**
		 * Is skipping prefix (#) ?
		 * @var boolean
		 */
		private $prefix = true;

		/**
		 * Line amount.
		 * @var number
		 */
		private $lines = 1;

	}

}
