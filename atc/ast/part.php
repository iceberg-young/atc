<?php
namespace atc\ast {

	class part extends \atc\ast {

		public function __toString() {
			return $this->content . $this->getDebugLocation();
		}

		public function done() {
			parent::done();
			if ( $this->content && is_a( $this->content, 'atc\ast' ) ) {
				$this->content->done();
			}
		}

		/**
		 * Parsed content.
		 * @var mixed
		 */
		protected $content;

	}

}
