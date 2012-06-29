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

		protected function createLoop( $c, $s ) {
			$this->loop = $this->createDeriver( 'part\before', array( 'part\dirty' ) );
			$this->loop->push( $c, $s );
		}

		protected function createBody() {
			$this->body = $this->createDeriver( 'part\block', array( 'body\call' ) );
		}

		/**
		 * Is post condition?
		 * @var boolean
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
				'trait' => '>',
				'build' => 'createPost',
				'optional' => true,
			),
			array(
				'build' => 'createLoop',
			),
			array(
				'trait' => '{',
				'build' => 'createBody',
			),
		);

	}

}
