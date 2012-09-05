<?php
namespace atc\ast\head\_as {

	class _function extends \atc\ast\head\_as {

		public function __toString() {
			return "{$this->access}{$this->name} AS {$this->link}({$this->init})" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'access',
				'optional' => true,
			),
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
				'template' => 'init',
				'optional' => true,
			),
		);

	}

}
