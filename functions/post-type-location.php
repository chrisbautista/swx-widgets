<?php
if(!is_post_type_defined('location')) die();
/**
 * Define Location Post Type
 *
 * @package default
 * @author codespud
 */ 

class CLASS_Location
{
 
	function __construct()
	{
		add_action( 'init', array($this, 'define_post_type'), 0 );
	}

	// Register Custom Post Type
	function define_post_type() {

		$labels = array(
			'name'                  => _x( 'Locations', 'Post Type General Name', 'swx_widgets' ),
			'singular_name'         => _x( 'Location', 'Post Type Singular Name', 'swx_widgets' ),
			'menu_name'             => __( 'Locations', 'swx_widgets' ),
			'name_admin_bar'        => __( 'Locations', 'swx_widgets' ),
			'archives'              => __( 'Locations', 'swx_widgets' ),
			'parent_item_colon'     => __( 'Parent Location:', 'swx_widgets' ),
			'all_items'             => __( 'All Locations', 'swx_widgets' ),
			'add_new_item'          => __( 'Add New Location', 'swx_widgets' ),
			'add_new'               => __( 'Add New', 'swx_widgets' ),
			'new_item'              => __( 'New Location', 'swx_widgets' ),
			'edit_item'             => __( 'Edit Location', 'swx_widgets' ),
			'update_item'           => __( 'Update Location', 'swx_widgets' ),
			'view_item'             => __( 'View Location', 'swx_widgets' ),
			'search_items'          => __( 'Search Location', 'swx_widgets' ),
			'not_found'             => __( 'Not found', 'swx_widgets' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'swx_widgets' ),
			'featured_image'        => __( 'Featured Image', 'swx_widgets' ),
			'set_featured_image'    => __( 'Set featured image', 'swx_widgets' ),
			'remove_featured_image' => __( 'Remove featured image', 'swx_widgets' ),
			'use_featured_image'    => __( 'Use as featured image', 'swx_widgets' ),
			'insert_into_item'      => __( 'Insert into item', 'swx_widgets' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'swx_widgets' ),
			'items_list'            => __( 'Locations list', 'swx_widgets' ),
			'items_list_navigation' => __( 'Locations list navigation', 'swx_widgets' ),
			'filter_items_list'     => __( 'Filter items list', 'swx_widgets' ),
		);
		$args = array(
			'label'                 => __( 'Locations', 'swx_widgets' ),
			'description'           => __( 'Locations ', 'swx_widgets' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'author', 'thumbnail',  ),
			'taxonomies'            => array( 'category', 'post_tag', 'regions'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'location', $args );

	}



}

new CLASS_Location();


