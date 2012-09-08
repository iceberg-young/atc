<?php
namespace atc\ast {

	class part extends \atc\ast {

		const COMPLETE_STATUS = parent::PUSH_OVERFLOW;

		public function __toString() {
			return $this->current . $this->getDebugLocation();
		}

		protected function onPush() {
			if ( $this->pushCondition() ) {
				if ( is_a( $this->current, __NAMESPACE__ ) ) {
					$this->current->push( $this->fresh, $this->space );
				}
				else $this->current .= $this->fresh;
				return parent::PUSH_CONTINUE;
			}
			else return static::COMPLETE_STATUS;
		}

	}

}
