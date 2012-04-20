<?php
namespace atc\ast\body {

	class file extends \atc\ast\body {

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $prefixes = array(
			'alias' => 5,
			'class' => 5,
			'scope' => 5,
			'require' => 7,
		);

	}

}
