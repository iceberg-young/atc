<?php
namespace atc {

	abstract class ast {

		public function __construct( builder $builder, $parent = null ) {
			$this->parent = $parent;
			$this->builder = $builder;

			$this->location = $this->builder->readLocation();
			$this->note = $this->builder->takeNote( $this->location->row );
			$this->log = new log( $this->builder, get_class( $this ) );
		}

		const PUSH_CONTINUE = 'continue';
		const PUSH_COMPLETE = 'complete';
		const PUSH_OVERFLOW = 'overflow';

		public function push( $c, $s ) {
			if ( $this->complete ) {
				$this->log->debug( "Pushing ($c) to a complete node." );
				return self::PUSH_OVERFLOW;
			}

			$this->fresh = $c;
			$this->space = $s;
			$status = $this->onPush();
			if ( self::PUSH_CONTINUE !== $status ) $this->complete();
			return $status;
		}

		public function complete() {
			if ( $this->complete ) return $this->log->debug( 'Completion has already been notified.' );

			$this->complete = true;
			return $this->onComplete();
		}

		protected function onPush() {
			if ( $this->current ) $status = $this->transfer();
			else {
				if ( !$this->identify ) {
					if ( $this->space ) $status = self::PUSH_CONTINUE;
					else {
						$this->builder->markLocation();
						$this->fragment = '';
						$this->length = 0;
						$this->identify = true;
					}
				}
				if ( $this->identify ) {
					$status = $this->onIdentify();
					$this->identify = self::PUSH_CONTINUE === $status;
					if ( $this->identify ) {
						if ( $this->space ) {
							$fragment = $this->getFragmentLog();
							$this->log->debug( "Child node must be identified from $fragment." );
						}
						$this->fragment .= $this->fresh;
						$this->length += strlen( $this->fresh );
					}
					elseif ( self::PUSH_COMPLETE === $status ) $status = self::PUSH_CONTINUE;
				}
			}
			return $status;
		}

		protected function onComplete() {
			if ( $this->identify ) {
				$fragment = $this->getFragmentLog();
				$this->fragment = null;
				return $this->log->error( "Has unidentified content $fragment." );
			}

			if ( $this->current && is_a( $this->current, __CLASS__ ) ) $this->current->complete();
		}

		protected function onIdentify() {
			$this->log->debug( __METHOD__ . ' must be overrided.' );
		}

		protected function isDeep() {
			return $this->builder->getLevel() > $this->location->level;
		}

		protected function isShallow() {
			return $this->builder->getLevel() < $this->location->level;
		}

		const DERIVER_PUSH_PEND = 'pend';
		const DERIVER_PUSH_LAST = 'last';
		const DERIVER_PUSH_NONE = 'none';
		const DERIVER_PUSH = self::DERIVER_PUSH_LAST;

		protected function appendChild() {
			$child = $this->current = call_user_func( $this->getChildCreator( func_get_args() ) );
			switch ( $child::DERIVER_PUSH ) {
				case self::DERIVER_PUSH_PEND:
					foreach ( str_split( $this->fragment ) as $p ) {
						$child->push( $p, false );
					} // goto DERIVER_PUSH_LAST

				case self::DERIVER_PUSH_LAST:
					$this->transfer();
					break;
			}
			return $child;
		}

		protected function getChildCreator( array $args ) {
			$type = array_shift( $args );
			array_unshift( $args, $this->builder, $this );
			$class = new \ReflectionClass( "atc\\ast\\$type" );
			return function() use($class, $args) {
				return $class->newInstanceArgs( $args );
			};
		}

		protected function getDebugLocation() {
			$debug = clone $this->location;
			$debug->type = get_class( $this );
			$debug->done = $this->complete;
			$debug->note = "{$this->note}";
			return "\t#" . json_encode( $debug ) . "\n";
		}

		protected function getFragmentLog() {
			return "({$this->fragment}[{$this->fresh}])";
		}

		private function transfer() {
			$status = $this->current->push( $this->fresh, $this->space );
			if ( self::PUSH_CONTINUE !== $status ) {
				$this->current = null;
				if ( self::PUSH_OVERFLOW === $status ) {
					if ( $this->identify ) die( $this->log->debug( 'Identified 2 nodes of the same level at the same time.' ) );
					$status = $this->onPush();
				}
				else $status = self::PUSH_CONTINUE;
			}
			return $status;
		}

		/**
		 * Newly pushed literal.
		 * @var string
		 */
		protected $fresh;

		/**
		 * Is newly pushed literal invisible?
		 * @var boolean
		 */
		protected $space;

		/**
		 * Pushed part during deriver identifying.
		 * @var string
		 */
		protected $fragment = '';

		/**
		 * Length of $fragment.
		 * @var integer
		 */
		protected $length = 0;

		/**
		 * Superior node.
		 * @var \atc\ast
		 */
		protected $parent;

		/**
		 * Current node.
		 * @var \atc\ast
		 */
		protected $current;

		/**
		 * Inferior nodes.
		 * @var array
		 */
		protected $children = array( );

		/**
		 * @var \atc\misc\builder
		 */
		protected $builder;

		/**
		 * @var \atc\log
		 */
		protected $log;

		/**
		 * @var \atc\ast\note
		 */
		protected $note;

		/**
		 * Location of the source beginning.
		 * @var object
		 */
		protected $location;

		/**
		 * Is identifying node?
		 * @var boolean
		 */
		private $identify = false;

		/**
		 * Is parsing finished?
		 * @var boolean
		 */
		private $complete = false;

	}

}
