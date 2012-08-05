<?php
namespace atc\ast\head {

	class _case extends \atc\ast\head {

		public function __toString() {
			return "CASE {$this->case} {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'case',
			),
			array(
				'template' => 'body',
			),
		);

	}

}
