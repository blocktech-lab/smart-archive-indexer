<?php

namespace Blocktech\Plugin\SmartArchiveIndexer\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface iLayouts {
	public function render( array $data, array $args = array() ) : string;
}
