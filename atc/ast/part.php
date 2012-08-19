<?php
namespace atc\ast {

	class part extends \atc\ast {

		public function __toString() {
			return $this->content . $this->getDebugLocation();
		}

		protected function createContent( $type ) {
			$content = "\\atc\\ast\\$type";
			$this->content = new $content( $this->getBuilder(), $this->getParent() );
		}

		/**
		 * Parsed content.
		 * @var mixed
		 */
		protected $content;

	}

}
