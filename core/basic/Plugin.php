<?php

namespace Blocktech\Plugin\SmartArchiveIndexer\Basic;

use Blocktech\Plugin\SmartArchiveIndexer\Authors\Load as LoadAuthors;
use Blocktech\Plugin\SmartArchiveIndexer\Dates\Load as LoadDates;
use Blocktech\Plugin\SmartArchiveIndexer\Terms\Load as LoadTerms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {
	private $wp_version;

	public function __construct() {
	}

	public static function instance() : Plugin {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new Plugin();
			$instance->run();
		}

		return $instance;
	}

	private function run() {
		global $wp_version;

		$this->wp_version = substr( str_replace( '.', '', $wp_version ), 0, 2 );

		define( 'SMARTARCHIVEINDEXER_WPV', absint( $this->wp_version ) );

		LoadDates::instance();
		LoadAuthors::instance();
		LoadTerms::instance();

		if ( function_exists( 'register_block_type' ) ) {
			Blocks::instance();
		}

		add_action( 'init', array( $this, 'styles' ), 15 );
		add_action( 'init', array( $this, 'init' ), 20 );

		add_filter( 'transition_post_status', array( $this, 'post_status' ), 10, 3 );
	}

	public function styles() {
		$_rtl   = is_rtl() ? '-rtl' : '';
		$_debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$_file  = SMARTARCHIVEINDEXER_URL . 'css/styles' . $_rtl . $_debug . '.css';

		wp_register_style( 'smartarchiveindexer', $_file, array(), SMARTARCHIVEINDEXER_VERSION );
	}

	public function init() {
		do_action( 'smartarchiveindexer-init' );
	}

	public function post_status( $new_status, $old_status, $post ) {
		if ( $new_status !== $old_status && ( $new_status == 'publish' || $old_status == 'publish' ) ) {
			do_action( 'smartarchiveindexer-clear-cache', $post->post_type );
		}
	}
}
