<?php
namespace atc\ast\body {

	class _scope extends \atc\ast\body {

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $prefixes = array(
			'scope' => 5,
			'alias' => 5,
			'class' => 5,
			'call' => 4,
		);

	}

}
