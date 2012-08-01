<?php
namespace atc\ast\body {

	class _file extends \atc\ast\body {

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $prefixes = array(
			'require' => 7,
			'scope' => 5,
			'alias' => 5,
		);

	}

}
