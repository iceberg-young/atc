<?php
namespace atc\ast\body {

	class _switch extends \atc\ast\body {

		/**
		 * Override parent.
		 * @var array
		 */
		protected static $prefixes = array(
			'case' => 4,
			'default' => 7,
		);

	}

}
