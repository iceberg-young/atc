<?php
namespace atc\ast {

	class part extends \atc\ast {

		public function __toString() {
			return $this->content . $this->getDebugLocation();
		}

		public function done() {
			if ( $this->content && is_a( $this->content, 'atc\ast' ) ) {
				$this->content->done();
			}
			parent::done();
		}

		/**
		 * Parsed content.
		 * @var mixed
		 */
		protected $content;

	}

}
