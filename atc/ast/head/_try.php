<?php
namespace atc\ast\head {

	class _try extends \atc\ast\head {

		public function __toString() {
			return "TRY {\n{$this->body}\n}" . $this->getDebugLocation();
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
