<?php
namespace atc\ast\head {

	class _else extends \atc\ast\head {

		public function __toString() {
			return "ELSE {\n{$this->body}\n}" . $this->getDebugLocation();
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
