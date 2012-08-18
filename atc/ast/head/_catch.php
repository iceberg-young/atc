<?php
namespace atc\ast\head {

	class _catch extends \atc\ast\head {

		public function __toString() {
			return "CATCH {$this->name} OF {$this->link} {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'name',
			),
			array(
				'trait' => 'of',
			),
			array(
				'template' => 'link',
			),
			array(
				'template' => 'body',
			),
		);

	}

}
