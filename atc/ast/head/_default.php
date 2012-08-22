<?php
namespace atc\ast\head {

	class _default extends \atc\ast\head {

		public function __toString() {
			return "DEFAULT [\n{$this->body}\n]" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'body',
			),
		);

	}

}
