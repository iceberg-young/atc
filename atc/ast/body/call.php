<?php
namespace atc\ast\body {

	class call extends \atc\ast\body {

		/**
		 * Required by parent.
		 * @var array
		 */
		protected static $prefixes = array(
			'include' => 7,
			'require' => 7,
			'alias' => 5,
			'let' => 3,
			'static' => 6,
			'for' => 3,
			'if' => 2,
			'switch' => 6,
			'while' => 5,
		);

		/**
		 * Required by parent.
		 * @var string
		 */
		protected static $fallback = 'statement';

	}

}
