<?php
namespace atc {

	class log {

		const DEBUG = 0;
		const ERROR = 1;
		const WARNING = 2;
		const NOTICE = 3;
		const INFO = 4;

		public function __construct( builder $builder, $source = null ) {
			$this->builder = $builder;
			$this->source = $source;
		}

		public function __call( $name, $arguments ) {
			$label = strtoupper( $name );
			$level = __CLASS__ . "::$label";
			if ( defined( $level ) && constant( $level ) <= $this->level ) {
				$location = json_encode( $this->builder->getLocation() );
				$message = array_shift( $arguments );
				error_log( "[$label] {$this->source} $location: $message" );
			}
		}

		/**
		 * Message filter.
		 * @var integer
		 */
		public $level = self::INFO;

		/**
		 * @var atc\builder
		 */
		private $builder;

		/**
		 * @var string
		 */
		private $source;

	}

}
