<?php
namespace atc\ast\head {

	class _each extends \atc\ast\head {

		public function __toString() {
			return "EACH {$this->ref}{$this->name} IN {$this->term} [\n{$this->body}\n]" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'ref',
				'optional' => true,
			),
			array(
				'template' => 'name',
			),
			array(
				'trait' => 'in',
			),
			array(
				'template' => 'term',
			),
			array(
				'template' => 'body',
			),
		);

	}

}
