<?php

/*-----------------------------------------------------------------------------------*/
/*	Add custom post type for News Pages
/*-----------------------------------------------------------------------------------*/

add_action('init', 'news_register');
function news_register() {
	$args = array(
		'label' => __('News'),
		'singular_label' => __('News'),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_icon' => plugins_url( '/images/icons/newspaper.png', dirname(__FILE__) ),
		'rewrite' => array('with_front' => false, 'slug' => 'about-us/news'),
		'has_archive' => true,
		'supports' => array('title', 'editor', 'thumbnail','excerpt','author','revisions','comments')
		//'taxonomies' => array('category', 'post_tag')
	);
	register_post_type( 'news' , $args );
}

// Show Meta-Box for News

?>