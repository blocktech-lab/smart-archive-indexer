<?php

namespace Blocktech\Plugin\SmartArchiveIndexer\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface iCache {
	public function clear( $post_type = 'post' );

	public function get( $post_type = 'post' );
}
