<?php
namespace atc\ast\body {

	class call extends \atc\ast\body {

		const FALLBACK = 'statement';

		/**
		 * Override parent.
		 * @var array
		 */
		protected static $prefixes = array(
			'include' => 7,
			'require' => 7,
			'scope' => 5,
			'alias' => 5,
			'let' => 3,
			'if' => 2,
			'switch' => 6,
			'for' => 3,
			'while' => 5,
			'try' => 3,
		);

	}

}
