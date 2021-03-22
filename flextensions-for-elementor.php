<?php
/**
 * Flextensions for Elementor WordPress Plugin.
 *
 * @package Flextensions
 *
 * Plugin Name: Flextensions for Elementor
 * Description: Widgets 
 * Plugin URI:  https://github.com/fleks/flextensions-for-elementor
 * Version:     1.0.4
 * Author:      Felix Herzog
 * Text Domain: flextensions
 */

 defined( 'ABSPATH' ) || die(); // Blocks direct access to the plugin PHP files.

define( 'FLEXTENSIONS', __FILE__ );

/**
 * Include the Flextensions_Widgets class.
 */
require plugin_dir_path( FLEXTENSIONS ) . 'class-flextensions-widgets.php';

add_action( 'elementor/elements/categories_registered', 'add_flextensions_category' );
function add_flextensions_category( $elements_manager ) {

    // New category array
	$categories = [];
    // Create flextensions category
	$categories['flextensions-category'] =
		[
			'title' => 'Flextensions',
			'icon'  => 'fa fa-superpowers'
		];

    // Merge Flextensions category with remaining categories
	$old_categories = $elements_manager->get_categories();
	$categories = array_merge($categories, $old_categories);
	$set_categories = function ( $categories ) {
		$this->categories = $categories;
	};
	$set_categories->call( $elements_manager, $categories );	
}