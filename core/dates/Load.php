<?php

namespace Blocktech\Plugin\SmartArchiveIndexer\Dates;

use Blocktech\Plugin\SmartArchiveIndexer\Base\iCache;
use Blocktech\Plugin\SmartArchiveIndexer\Base\iLayouts;
use Blocktech\Plugin\SmartArchiveIndexer\Base\iLoad;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Load implements iLoad {
	protected $post_type;

	public function __construct() {
	}

	public static function instance() : Load {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new Load();
			$instance->run();
		}

		return $instance;
	}

	protected function run() {
		add_action( 'smartarchiveindexer-init', array( $this, 'init' ) );
		add_action( 'smartarchiveindexer-clear-cache', array( $this, 'clear_cache' ) );
	}

	public function init() {
		$this->post_type = apply_filters( 'smartarchiveindexer-dates-post-types', 'post' );

		add_shortcode( 'smartarchiveindexer-dates', array( $this, 'shortcode' ) );
	}

	public function clear_cache( $post_type ) {
		$this->cache()->clear( $post_type );
	}

	public function cache() : iCache {
		$obj = apply_filters( 'smartarchiveindexer-dates-cache-object', null );

		if ( ! $obj ) {
			$obj = Cache::instance();
		}

		return $obj;
	}

	public function layouts() : iLayouts {
		$obj = apply_filters( 'smartarchiveindexer-dates-layouts-object', null );

		if ( ! $obj ) {
			$obj = Layouts::instance();
		}

		return $obj;
	}

	public function shortcode( $atts = array() ) : string {
		$defaults = array(
			'_source'              => 'shortcode',
			'layout'               => 'basic',
			'post_type'            => $this->post_type,
			'order'                => 'desc',
			'years'                => array(),
			'year'                 => 'show',
			'month'                => 'auto',
			'class'                => '',
			'show-year-counts'     => true,
			'show-month-counts'    => true,
			'show-day-counts'      => false,
			'var-font-size'        => '',
			'var-line-height'      => '',
			'var-year-background'  => '',
			'var-year-color'       => '',
			'var-month-background' => '',
			'var-month-color'      => '',
			'var-day-background'   => '',
			'var-day-color'        => '',
		);

		$atts                      = shortcode_atts( $defaults, $atts );
		$atts['show-year-counts']  = is_bool( $atts['show-year-counts'] ) ? $atts['show-year-counts'] : $atts['show-year-counts'] === 'true';
		$atts['show-month-counts'] = is_bool( $atts['show-month-counts'] ) ? $atts['show-month-counts'] : $atts['show-month-counts'] === 'true';
		$atts['show-day-counts']   = is_bool( $atts['show-day-counts'] ) ? $atts['show-day-counts'] : $atts['show-day-counts'] === 'true';

		if ( ! empty( $atts['years'] ) && is_string( $atts['years'] ) ) {
			$atts['years'] = explode( ',', $atts['years'] );
			$atts['years'] = array_map( 'absint', $atts['years'] );
			$atts['years'] = array_filter( $atts['years'] );
		}

		$data = $this->cache()->get( $atts['post_type'] );

		wp_enqueue_style( 'smartarchiveindexer' );

		if ( ! empty( $data ) ) {
			return $this->layouts()->render( $data, $atts );
		}

		return '';
	}
}
