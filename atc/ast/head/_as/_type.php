<?php
namespace atc\ast\head\_as {

	class _type extends \atc\ast\head\_as {

		public function __toString() {
			return "{$this->name} AS {$this->link}({$this->call_arguments})" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'name',
			),
			array(
				'trait' => 'as',
			),
			array(
				'template' => 'link',
			),
			array(
				'template' => 'call_arguments',
				'optional' => true,
			),
		);

	}

}
