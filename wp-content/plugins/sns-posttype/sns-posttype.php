<?php
/*
Plugin Name: SNS Posttype
Plugin URI: http://snstheme.com
Description: Define some postype for snstheme.com
Version: 1.0
Author URI: http://snstheme.com
License: GPL2+
*/

class SNS_Posttype{
	function __construct(){
		add_action('init', array($this,'sns_posttype_brand'));
		add_action('init', array($this,'sns_posttype_testimonial'));
		add_action('init', array($this,'sns_posttype_partner'));
	}
	function sns_posttype_brand(){
		$labels = array(
			'name' => __( 'Brand', 'snshadona' ),
			'singular_name' => __( 'Brand', 'snshadona' ),
			'add_new' => __( 'Add New Brand', 'snshadona' ),
			'add_new_item' => __( 'Add New Brand', 'snshadona' ),
			'edit_item' => __( 'Edit Brand', 'snshadona' ),
			'new_item' => __( 'New Brand', 'snshadona' ),
			'view_item' => __( 'View Brand', 'snshadona' ),
			'search_items' => __( 'Search Brands', 'snshadona' ),
			'not_found' => __( 'No Brands found', 'snshadona' ),
			'not_found_in_trash' => __( 'No Brands found in Trash', 'snshadona' ),
			'parent_item_colon' => __( 'Parent Brand:', 'snshadona' ),
			'menu_name' => __( 'Our Brands', 'snshadona' ),
		);

		$args = array(
		    'labels' => $labels,
		    'hierarchical' => true,
		    'description' => 'List Brands',
		    'supports' => array( 'title', 'thumbnail' ),
		    'public' => false,
		    'show_ui' => true,
		    'show_in_menu' => true,
		    'menu_position' => 5,
		    'show_in_nav_menus' => true,
		    'publicly_queryable' => true,
		    'exclude_from_search' => false,
		    'has_archive' => true,
		    'query_var' => true,
		    'can_export' => true,
		    'rewrite' => true,
		    'capability_type' => 'post'
		);
		register_post_type( 'brand', $args );
	}
	function sns_posttype_partner(){
		$labels = array(
			'name' => __( 'Partner', 'snshadona' ),
			'singular_name' => __( 'Partner', 'snshadona' ),
			'add_new' => __( 'Add New Partner', 'snshadona' ),
			'add_new_item' => __( 'Add New Partner', 'snshadona' ),
			'edit_item' => __( 'Edit Partner', 'snshadona' ),
			'new_item' => __( 'New Partner', 'snshadona' ),
			'view_item' => __( 'View Partner', 'snshadona' ),
			'search_items' => __( 'Search Partners', 'snshadona' ),
			'not_found' => __( 'No Partners found', 'snshadona' ),
			'not_found_in_trash' => __( 'No Partners found in Trash', 'snshadona' ),
			'parent_item_colon' => __( 'Parent Partner:', 'snshadona' ),
			'menu_name' => __( 'Our Partners', 'snshadona' ),
		);

		$args = array(
		    'labels' => $labels,
		    'hierarchical' => true,
		    'description' => 'List Partners',
		    'supports' => array( 'title', 'thumbnail' ),
		    'public' => false,
		    'show_ui' => true,
		    'show_in_menu' => true,
		    'menu_position' => 5,
		    'show_in_nav_menus' => true,
		    'publicly_queryable' => true,
		    'exclude_from_search' => false,
		    'has_archive' => true,
		    'query_var' => true,
		    'can_export' => true,
		    'rewrite' => true,
		    'capability_type' => 'post'
		);
		register_post_type( 'partner', $args );
	}
	function sns_posttype_testimonial(){
		$labels = array(
			'name' => __( 'Testimonial', 'snshadona' ),
			'singular_name' => __( 'Testimonial', 'snshadona' ),
			'add_new' => __( 'Add New Testimonial', 'snshadona' ),
			'add_new_item' => __( 'Add New Testimonial', 'snshadona' ),
			'edit_item' => __( 'Edit Testimonial', 'snshadona' ),
			'new_item' => __( 'New Testimonial', 'snshadona' ),
			'view_item' => __( 'View Testimonial', 'snshadona' ),
			'search_items' => __( 'Search Testimonial', 'snshadona' ),
			'not_found' => __( 'No Testimonial found', 'snshadona' ),
			'not_found_in_trash' => __( 'No Testimonial found in Trash', 'snshadona' ),
			'parent_item_colon' => __( 'Parent Testimonial:', 'snshadona' ),
			'menu_name' => __( 'Testimonial', 'snshadona' ),
		);

		$args = array(
		    'labels' => $labels,
		    'hierarchical' => true,
		    'description' => 'List Brands',
		    'supports' => array( 'title', 'editor', 'thumbnail'),
		    'public' => false,
		    'show_ui' => true,
		    'show_in_menu' => true,
		    'menu_position' => 6,
		    'show_in_nav_menus' => true,
		    'publicly_queryable' => true,
		    'exclude_from_search' => false,
		    'has_archive' => true,
		    'query_var' => true,
		    'can_export' => true,
		    'rewrite' => true,
		    'capability_type' => 'post'
		);
		register_post_type( 'testimonial', $args );
	}  	
}
function snsposttype_load(){
	global $snsposttype;
	$snsposttype = new SNS_Posttype();
}
add_action( 'plugins_loaded', 'snsposttype_load' );
?>