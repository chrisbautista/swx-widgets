<?php

/*-----------------------------------------------------------------------------------*/
/*	Add custom post type for Clients Pages
/*-----------------------------------------------------------------------------------*/


add_action( 'init', 'create_cliental_post_type' );

function create_cliental_post_type() {




$args = array(
    'description' => 'Cliental Post Type',
	'labels' => array(
    'name'=> 'Clients',
    'singular_name' => 'Client',
	),
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'exclude_from_search' => false,
    'has_archive' => true,
    'hierarchical' => true,
    'taxonomies' => array('cliental_types'),
	'menu_icon' => plugins_url( '/images/icons/clients.png', dirname(__FILE__) ),

  );

    register_post_type( 'cliental' , $args );
}



add_action('init' , 'cliental_tax' );
function cliental_tax()
  {
     $labels = array(
    'name' => _x( 'Client Types', 'taxonomy general name' ),
    'singular_name' => _x( 'Client Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Job Types' ),
    'all_items' => __( 'All Client Types' ),
    'parent_item' => __( 'Parent Client Types' ),
    'parent_item_colon' => __( 'Parent Client Type:' ),
    'edit_item' => __( 'Edit Client Type' ),
    'update_item' => __( 'Update Client Type' ),
    'add_new_item' => __( 'Add New Client Type' ),
    'new_item_name' => __( 'New Client Type' ),
  );

  register_taxonomy('cliental_type',array('cliental'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'show_in_nav_menus' => true,
     'rewrite' => array('slug' => 'cliental-types', 'with_front' => false),
  ));

}

?>