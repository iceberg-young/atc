<?php
namespace atc\ast\part {

	class string extends \atc\ast\part {

		public function __toString() {
			return '"' . addslashes( $this->children['content'] ) . '"' . $this->current . $this->getDebugLocation();
		}

		public function onPush() {
			return $this->{$this->parser}();
		}

		protected function pushCondition() {
			return preg_match( '/[a-z]/i', $this->fresh );
		}

		private function parseType() {
			$this->type = $this->fresh;
			$this->parser = 'parseContent';
			return parent::PUSH_CONTINUE;
		}

		private function parseContent() {
			if ( $this->isShallow() ) {
				if ( '`' === $this->type ) {
					$d = strpos( $this->current, '`' ) + 1;
					$this->current = substr( $this->current, $d, -$d );
				}
				$this->children['content'] = $this->current;
				$this->current = '';
				$this->parser = 'parseSuffix';
			}
			else $this->current .= $this->fresh;
			return parent::PUSH_CONTINUE;
		}

		private function parseSuffix() {
			return parent::onPush();
		}

		/**
		 * One of TYPE_*.
		 * @var string
		 */
		private $type;

		/**
		 * Current parser function name.
		 * @var string
		 */
		private $parser = 'parseType';

	}

}
