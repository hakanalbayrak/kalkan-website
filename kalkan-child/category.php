<?php
/**
 * Category archives use the same self-contained Kalkan article listing as the
 * main blog instead of falling back to the Blocksy parent archive design.
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require get_stylesheet_directory() . '/home.php';
