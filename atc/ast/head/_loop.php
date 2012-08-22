<?php
namespace atc\ast\head {

	class _loop extends \atc\ast\head {

		public function __toString() {
			return "LOOP {$this->name} [\n{$this->body}\n]" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'name',
				'optional' => true,
			),
			array(
				'template' => 'body',
			),
		);

	}

}
