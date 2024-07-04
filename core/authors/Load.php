<?php

namespace Blocktech\Plugin\SmartArchiveIndexer\Authors;

use Blocktech\Plugin\SmartArchiveIndexer\Base\iCache;
use Blocktech\Plugin\SmartArchiveIndexer\Base\iLayouts;
use Blocktech\Plugin\SmartArchiveIndexer\Base\iLoad;
use Blocktech\Plugin\SmartArchiveIndexer\Basic\ObjectsSort;

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
		$this->post_type = apply_filters( 'smartarchiveindexer-authors-post-types', 'post' );

		add_shortcode( 'smartarchiveindexer-authors', array( $this, 'shortcode' ) );
	}

	public function clear_cache( $post_type ) {
		$this->cache()->clear( $post_type );
	}

	public function cache() : iCache {
		$obj = apply_filters( 'smartarchiveindexer-authors-cache-object', null );

		if ( ! $obj ) {
			$obj = Cache::instance();
		}

		return $obj;
	}

	public function layouts() : iLayouts {
		$obj = apply_filters( 'smartarchiveindexer-authors-layouts-object', null );

		if ( ! $obj ) {
			$obj = Layouts::instance();
		}

		return $obj;
	}

	public function shortcode( $atts = array() ) : string {
		$defaults = array(
			'_source'         => 'shortcode',
			'layout'          => 'basic',
			'post_type'       => $this->post_type,
			'orderby'         => 'posts',
			'order'           => 'desc',
			'avatar'          => 24,
			'columns'         => 3,
			'class'           => '',
			'show-counts'     => true,
			'var-font-size'   => '',
			'var-line-height' => '',
			'var-background'  => '',
			'var-color'       => '',
		);

		$atts                = shortcode_atts( $defaults, $atts );
		$atts['show-counts'] = is_bool( $atts['show-counts'] ) ? $atts['show-counts'] : $atts['show-counts'] === 'true';

		$data = $this->cache()->get( $atts['post_type'] );
		$data = $this->prepare_data( $data, $atts['orderby'], $atts['order'] );

		if ( ! empty( $data ) ) {
			wp_enqueue_style( 'smartarchiveindexer' );

			return $this->layouts()->render( $data, $atts );
		}

		return '';
	}

	private function prepare_data( $data, $orderby, $order ) : array {
		$valid = array( 'id', 'name', 'slug', 'email', 'posts' );

		if ( in_array( $orderby, $valid ) ) {
			$input  = array();
			$output = array();

			foreach ( $data as $key => $item ) {
				$input[ $key ] = (object) $item;
			}

			$sort = new ObjectsSort( $input, array( array( 'property' => $orderby, 'order' => $order ) ), true );

			foreach ( $sort->sorted as $key => $item ) {
				$output[ $key ] = (array) $item;
			}

			return $output;
		}

		return $data;
	}
}
