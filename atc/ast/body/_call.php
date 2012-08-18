<?php
namespace atc\ast\body {

	class _call extends \atc\ast\body {

		const FALLBACK = 'statement';

		/**
		 * Override parent.
		 * @var array
		 */
		protected static $prefixes = array(
			'include' => 7,
			'require' => 7,
			'alias' => 5,
			'if' => 2,
			'else' => 4,
			'switch' => 6,
			'veer' => 4,
			'try' => 3,
			'catch' => 5,
			'throw' => 5,
			'each' => 4,
			'loop' => 4,
			'break' => 5,
			'rewind' => 6,
			'return' => 6,
		);

	}

}
