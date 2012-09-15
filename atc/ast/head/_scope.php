<?php
namespace atc\ast\head {

	class _scope extends \atc\ast\head {

		public function __toString() {
			return "SCOPE {$this->access}{$this->name} {{$this->template}} [\n{$this->body}\n]" . $this->getDebugLocation();
		}

		protected function createBody() {
			return $this->appendChild( 'part\block', 'body\_scope' );
		}

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'template' => 'access',
				'optional' => true,
			),
			array(
				'template' => 'name',
			),
			array(
				'template' => 'template',
				'optional' => true,
			),
			array(
				'template' => 'body',
			),
		);

	}

}
