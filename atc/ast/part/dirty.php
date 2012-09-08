<?php
namespace atc\ast\part {

	class dirty extends \atc\ast\part {

		const DERIVER_PUSH = parent::DERIVER_PUSH_PEND;

		public function pushCondition() {
			return (';' !== $this->fresh) || $this->isDeep();
		}

	}

}
