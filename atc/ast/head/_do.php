<?php
namespace atc\ast\head {

	class _do extends \atc\ast {

		public function __toString() {
			return "^^DO {$this->body}$$" . json_encode( $this->getSource() );
		}

		public function push( $c ) {
			if ( null === $this->body && preg_match( '/\S/', $c ) ) {
				if ( '{' !== $c ) trigger_error( '{ required', E_USER_ERROR );
				$builder = $this->getBuilder();
				$builder->pushSource();
				$this->body = new \atc\ast\part\block( 'body\call', $builder, $this );
				return false;
			}
			if ( $this->body ) return $this->body->push( $c );
		}

		private $body;

	}

}
