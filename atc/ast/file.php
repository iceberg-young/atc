<?php
namespace atc\ast {

	class file extends \atc\ast {

		/**
		 * Required by parent.
		 * @var array
		 */
		protected static $prefixes = array(
			'alias' => 5,
			'class' => 5,
			'scope' => 5,
			'require' => 7,
		);

		/**
		 * Required by parent.
		 * @var string
		 */
		protected static $fallback = 'error';

	}

}
