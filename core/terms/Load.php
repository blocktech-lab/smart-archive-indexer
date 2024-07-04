<?php

namespace Blocktech\Plugin\SmartArchiveIndexer\Terms;

use Blocktech\Plugin\SmartArchiveIndexer\Base\iCache;
use Blocktech\Plugin\SmartArchiveIndexer\Base\iLayouts;
use Blocktech\Plugin\SmartArchiveIndexer\Base\iLoad;
use Blocktech\Plugin\SmartArchiveIndexer\Basic\ObjectsSort;
use WP_Term;

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
		$this->post_type = apply_filters( 'smartarchiveindexer-terms-post-types', 'post' );

		add_shortcode( 'smartarchiveindexer-terms', array( $this, 'shortcode' ) );
	}

	public function clear_cache( $post_type ) {
		$this->cache()->clear( $post_type );
	}

	public function cache() : iCache {
		$obj = apply_filters( 'smartarchiveindexer-terms-cache-object', null );

		if ( ! $obj ) {
			$obj = Cache::instance();
		}

		return $obj;
	}

	public function layouts() : iLayouts {
		$obj = apply_filters( 'smartarchiveindexer-terms-layouts-object', null );

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
			'taxonomy'        => 'category',
			'orderby'         => 'posts',
			'order'           => 'desc',
			'columns'         => 4,
			'class'           => '',
			'show-counts'     => true,
			'var-font-size'   => '',
			'var-line-height' => '',
			'var-background'  => '',
			'var-color'       => '',
		);

		$atts                = shortcode_atts( $defaults, $atts );
		$atts['columns']     = absint( $atts['columns'] );
		$atts['show-counts'] = is_bool( $atts['show-counts'] ) ? $atts['show-counts'] : $atts['show-counts'] === 'true';

		$data  = $this->cache()->get( $atts['post_type'] );
		$terms = $data[ $atts['taxonomy'] ] ?? array();

		wp_enqueue_style( 'smartarchiveindexer' );

		if ( ! empty( $terms ) ) {
			_prime_term_caches( array_keys( $terms ) );

			$terms = $this->prepare_data( $terms, $atts['taxonomy'], $atts['orderby'], $atts['order'] );

			return $this->layouts()->render( $terms, $atts );
		}

		return '';
	}

	private function prepare_data( $data, $taxonomy, $orderby, $order ) : array {
		$input = array();

		foreach ( $data as $term_id => $count ) {
			$term = get_term_by( 'id', $term_id, $taxonomy );

			if ( $term instanceof WP_Term ) {
				$input[ $term_id ] = (object) array(
					'id'       => $term->term_id,
					'name'     => $term->name,
					'slug'     => $term->slug,
					'taxonomy' => $term->taxonomy,
					'posts'    => $count,
				);
			}
		}

		$valid = array( 'id', 'name', 'slug', 'posts' );

		if ( in_array( $orderby, $valid ) ) {
			$output = array();

			$sort = new ObjectsSort( $input, array( array( 'property' => $orderby, 'order' => $order ) ), true );

			foreach ( $sort->sorted as $key => $item ) {
				$output[ $key ] = (array) $item;
			}

			return $output;
		}

		return $input;
	}
}
