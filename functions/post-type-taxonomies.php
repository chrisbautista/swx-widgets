<?php

function add_custom_taxonomies() {

	// taxonomies
	register_taxonomy(
			'industry',
			array( 'partners','customers','posts','news','events'),
			array(
				'label' => __( 'Industries' ),
				'rewrite' => array('slug' => 'industry', 'with_front' => true),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'capabilities' => array(
					'assign_terms' => 'edit_guides',
					'edit_terms' => 'publish_guides'
				)
			)
		);
	register_taxonomy(
			'product',
			array( 'partners','customers','posts','news','events'),
			array(
				'label' => __( 'Products' ),
				'rewrite' => array('slug' => 'product', 'with_front' => true),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'capabilities' => array(
					'assign_terms' => 'edit_guides',
					'edit_terms' => 'publish_guides'
				)
			)
		);
 	/*register_taxonomy(
			'region',
			array( 'customers'),
			array(
				'label' => __( 'Regions' ),
				'rewrite' => array('slug' => 'region', 'with_front' => true),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'capabilities' => array(
					'assign_terms' => 'edit_guides',
					'edit_terms' => 'publish_guides'
				)
			)
		);  
	*/
	register_taxonomy(
			'country',
			array( 'partners','customers'),
			array(
				'label' => __( 'Countries' ),
				'rewrite' => array('slug' => 'country', 'with_front' => true),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'capabilities' => array(
					'assign_terms' => 'edit_guides',
					'edit_terms' => 'publish_guides'
				)
			)
		);
	// taxonomies
	register_taxonomy(
			'partner_level',
			'partners',
			array(
				'label' => __( 'Partner Levels' ),
				'rewrite' => array('slug' => 'level', 'with_front' => true),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'capabilities' => array(
					'assign_terms' => 'edit_guides',
					'edit_terms' => 'publish_guides'
				)
			)
		);

 /*

	// taxonomies
	register_taxonomy(
			'industry',
			array( 'partners','customers','posts'),
			array(
				'label' => __( 'Industries' ),
				'rewrite' => array('slug' => 'industry', 'with_front' => true),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'show_in_nav_menus' => true,
				'capabilities' => array(
					'assign_terms' => 'edit_guides',
					'edit_terms' => 'publish_guides'
				)
			)
		);
	register_taxonomy(
			'product',
			array( 'partners','customers','posts' ),
			array(
				'label' => __( 'Products' ),
				'rewrite' => array('slug' => 'product', 'with_front' => true),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'show_in_nav_menus' => true,
				'capabilities' => array(
					'assign_terms' => 'edit_guides',
					'edit_terms' => 'publish_guides'
				)
			)
		);
	register_taxonomy(
			'region',
			array( 'partners','customers','posts' ),
			array(
				'label' => __( 'Regions' ),
				'rewrite' => array('slug' => 'region', 'with_front' => true),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'show_in_nav_menus' => true,
				'capabilities' => array(
					'assign_terms' => 'edit_guides',
					'edit_terms' => 'publish_guides'
				)
			)
		);
	// taxonomies
	register_taxonomy(
			'partner_level',
			'partners',
			array(
				'label' => __( 'Partner Levels' ),
				'rewrite' => array('slug' => 'level', 'with_front' => true),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'show_in_nav_menus' => true,
				'capabilities' => array(
					'assign_terms' => 'edit_guides',
					'edit_terms' => 'publish_guides'
				)
			)
		);
  */

}
add_action( 'init', 'add_custom_taxonomies', 0 )
 ?>