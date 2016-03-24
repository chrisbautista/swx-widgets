<?php
if(!is_post_type_defined('report')) die();
/**
 * Define Report Post Type
 *
 * @package default
 * @author codespud
 */ 

class CLASS_Report
{
 
	function __construct()
	{
		add_action( 'init', array($this, 'define_post_type'), 0 );
	}

	// Register Custom Post Type
	function define_post_type() {

		$labels = array(
			'name'                  => _x( 'Reports', 'Post Type General Name', 'swx_widgets' ),
			'singular_name'         => _x( 'Report', 'Post Type Singular Name', 'swx_widgets' ),
			'menu_name'             => __( 'Reports', 'swx_widgets' ),
			'name_admin_bar'        => __( 'Reports', 'swx_widgets' ),
			'archives'              => __( 'Reports', 'swx_widgets' ),
			'parent_item_colon'     => __( 'Parent Report:', 'swx_widgets' ),
			'all_items'             => __( 'All Reports', 'swx_widgets' ),
			'add_new_item'          => __( 'Add New Report', 'swx_widgets' ),
			'add_new'               => __( 'Add New', 'swx_widgets' ),
			'new_item'              => __( 'New Report', 'swx_widgets' ),
			'edit_item'             => __( 'Edit Report', 'swx_widgets' ),
			'update_item'           => __( 'Update Report', 'swx_widgets' ),
			'view_item'             => __( 'View Report', 'swx_widgets' ),
			'search_items'          => __( 'Search Report', 'swx_widgets' ),
			'not_found'             => __( 'Not found', 'swx_widgets' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'swx_widgets' ),
			'featured_image'        => __( 'Featured Image', 'swx_widgets' ),
			'set_featured_image'    => __( 'Set featured image', 'swx_widgets' ),
			'remove_featured_image' => __( 'Remove featured image', 'swx_widgets' ),
			'use_featured_image'    => __( 'Use as featured image', 'swx_widgets' ),
			'insert_into_item'      => __( 'Insert into item', 'swx_widgets' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'swx_widgets' ),
			'items_list'            => __( 'Reports list', 'swx_widgets' ),
			'items_list_navigation' => __( 'Reports list navigation', 'swx_widgets' ),
			'filter_items_list'     => __( 'Filter items list', 'swx_widgets' ),
		);
		$args = array(
			'label'                 => __( 'Report', 'swx_widgets' ),
			'description'           => __( 'Reports ', 'swx_widgets' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'author', 'thumbnail',  ),
			'taxonomies'            => array( 'category', 'post_tag', 'platforms', 'products', 'roles' ),
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
		register_post_type( 'report', $args );

	}



}

new CLASS_Report();


