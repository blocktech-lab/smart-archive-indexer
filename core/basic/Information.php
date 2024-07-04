<?php

namespace Blocktech\Plugin\SmartArchiveIndexer\Basic;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Information {
	public $code = 'smartarchiveindexer';

	public $version = '2.3';
	public $build = 32;
	public $edition = 'free';
	public $status = 'stable';
	public $updated = '2024.07.04';
	public $released = '2024.07.04';

	public $author_name = 'Blocktech Lab';
	public $author_url = 'https://blocktech.dev';

	public $php = '7.4';
	public $wordpress = '6.0';

	public static function instance() : Information {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new Information();
		}

		return $instance;
	}
}
