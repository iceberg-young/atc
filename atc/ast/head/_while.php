<?php
namespace atc\ast\head {

	class _while extends \atc\ast\head {

		public function __toString() {
			$post = $this->post ? '>' : '';
			return "WHILE $post ({$this->loop}) {\n{$this->body}\n}" . $this->getDebugLocation();
		}

		protected function createPost() {
			return $this->post = true;
		}

		protected function createLoop() {
			$this->loop = $this->createDeriver( 'part\block', array( 'part\dirty' ), false );
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\call' ), false );
		}

		/**
		 * Is post condition?
		 * @var bool
		 */
		private $post;

		/**
		 * Condition expression.
		 * @var \atc\ast\part\expression
		 */
		private $loop;

		/**
		 * @var \atc\ast\part\block
		 */
		private $body;

		/**
		 * Override parent's.
		 * @var array
		 */
		protected static $patterns = array(
			array(
				'trait' => '/>/',
				'build' => 'createPost',
				'optional' => true,
			),
			array(
				'trait' => '/\(/',
				'build' => 'createLoop',
			),
			array(
				'trait' => '/{/',
				'build' => 'createBody',
			),
		);

	}

}
