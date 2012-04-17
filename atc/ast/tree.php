<?php
namespace atc\ast {

	class tree {

		public function __toString() {
			$dump = "Main:\n{$this->entry}\n";
			foreach ( $this->scopes as $name => $scope ) {
				$dump .= "\nScope [$name]:$scope\n";
			}
			return $dump;
		}

		public function getEntry() {
			return $this->entry;
		}

		public function setEntry( body\call $block ) {
			$this->entry = $block;
		}

		public function getScope( $name ) {
			if ( !isset( $this->scopes[$name] ) ) {
				$this->scopes[$name] = new scope( $name );
			}
			return $this->scopes[$name];
		}

		/**
		 * The entry call.
		 * @var call
		 */
		private $entry;

		/**
		 * Root scopes.
		 * @var array
		 */
		private $scopes = array( );

	}

}
