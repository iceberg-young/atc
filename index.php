<?php
spl_autoload_register( function($name) {
	require_once __DIR__ . '/' . str_replace( '\\', '/', $name ) . '.php';
} );

if ( isset( $argv[1] ) ) {
	$builder = new atc\builder();
	$builder->parse( $argv[1] );
	echo $builder->getNode();
}
else {
	die( "Give me the file name of the entry." );
}
