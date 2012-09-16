<?php
namespace atc\ast\head {

	class _catch extends \atc\ast\head {

		public function __toString() {
			return "CATCH {$this->ref}{$this->declare} [\n{$this->body}\n]" . $this->getDebugLocation();
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
				'template' => 'declare',
			),
			array(
				'template' => 'body',
			),
		);

	}

}
