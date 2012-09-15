<?php
namespace atc\ast {

	class note extends \atc\ast {

		public function __toString() {
			return $this->current . $this->getDebugLocation();
		}

		public function adjacent( $row, $more = false ) {
			$adjacent = $this->location->row + $this->lines >= $row;
			if ( $adjacent && $more ) {
				$this->current .= PHP_EOL;
				$this->prefix = true;
				++$this->lines;
			}
			return $adjacent;
		}

		protected function onPush() {
			$this->prefix ? $this->prefix = false : $this->current .= $this->fresh;
			return parent::PUSH_CONTINUE;
		}

		/**
		 * Is skipping prefix (#)?
		 * @var boolean
		 */
		private $prefix = true;

		/**
		 * Line amount.
		 * @var integer
		 */
		private $lines = 1;

	}

}
