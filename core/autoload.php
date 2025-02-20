<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function btl_plugin_smartarchiveindexer_autoload($class ) {
	$path = dirname( __FILE__ ) . '/';
	$base = 'Blocktech\\Plugin\\SmartArchiveIndexer\\';

	if ( substr( $class, 0, strlen( $base ) ) == $base ) {
		$clean = substr( $class, strlen( $base ) );

		$parts = explode( '\\', $clean );

		$class_name = $parts[ count( $parts ) - 1 ];
		unset( $parts[ count( $parts ) - 1 ] );

		$class_namespace = join( '/', $parts );
		$class_namespace = strtolower( $class_namespace );

		$path .= $class_namespace . '/' . $class_name . '.php';

		if ( file_exists( $path ) ) {
			include( $path );
		}
	}
}

spl_autoload_register('btl_plugin_smartarchiveindexer_autoload');
