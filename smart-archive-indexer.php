<?php
/**
 * Plugin Name:       Smart Archive Indexer
 * Plugin URI:        https://blocktech.dev/
 * Description:       Display indexes by dates (years, months, and days archives), authors, and taxonomy terms for quick navigation and filtering of posts.
 * Author:            Blocktech Lab
 * Author URI:        https://blocktech.dev/
 * Text Domain:       smartarchiveindexer
 * Version:           2.3
 * Requires at least: 6.1
 * Tested up to:      6.6
 * Requires PHP:      7.4
 *
 * @package SmartArchiveIndexer
 */

use Blocktech\Plugin\SmartArchiveIndexer\Basic\Plugin;

const SMARTARCHIVEINDEXER_VERSION = '2.3';

$smartarchiveindexer_dirname_basic = dirname( __FILE__ ) . '/';
$smartarchiveindexer_urlname_basic = plugins_url( '/', __FILE__ );

define( 'SMARTARCHIVEINDEXER_PATH', $smartarchiveindexer_dirname_basic );
define( 'SMARTARCHIVEINDEXER_URL', $smartarchiveindexer_urlname_basic );
define( 'SMARTARCHIVEINDEXER_BLOCKS_PATH', $smartarchiveindexer_dirname_basic . 'build/blocks/' );

require_once( SMARTARCHIVEINDEXER_PATH . 'core/autoload.php' );

Plugin::instance();
