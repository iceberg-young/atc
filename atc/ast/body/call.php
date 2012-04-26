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
			'alias' => 5,
			'let' => 3,
			'static' => 6,
			'scope' => 5,
			'for' => 3,
			'if' => 2,
			'switch' => 6,
			'while' => 5,
		);

	}

}
