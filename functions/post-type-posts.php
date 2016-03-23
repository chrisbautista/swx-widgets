<?php
/*-----------------------------------------------------------------------------------*/
/* Remove Default Posts
/* http://wordpress.stackexchange.com/questions/52099/how-to-remove-entire-admin-menu/52151#52151
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_menu', 'remove_admin_menus' );
add_action( 'admin_menu', 'remove_admin_submenus' );

//Remove top level admin menus
function remove_admin_menus() {
    remove_menu_page( 'edit.php' );
}
//Remove sub level admin menus
function remove_admin_submenus() {
}

// http://www.jimmyscode.com/remove-wp-seo-menu-bar/
// remove default post and WPSEO plugin menu from "+New" admin bar
// Inspired by http://wordpress.org/support/topic/filter-to-remove-wordpress-logopages-from-admin-bar
add_action('wp_before_admin_bar_render', 'remove_wpseo_menu', 0);
function remove_wpseo_menu() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wpseo-menu');
  $wp_admin_bar->remove_menu('new-post');  
  $wp_admin_bar->remove_menu('new-user');  
}


/*-----------------------------------------------------------------------------------*/
/*	Add custom post type for Posts
/*-----------------------------------------------------------------------------------*/

add_action('init', 'posts_register');
function posts_register() {
	$args = array(
		'label' => __('Blog'),
		'singular_label' => __('Blog'),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'capability_type' => 'page',
		'hierarchical' => false,
		'menu_icon' => plugins_url( '/images/icons/award_star_silver_3.png', dirname(__FILE__) ),
		'rewrite' => array('with_front' => false, 'slug' => 'blog'),
		'has_archive' => true,
		'supports' => array('title', 'editor', 'excerpt','author','revisions','comments')
		//'taxonomies' => array('category', 'post_tag')
	);
	register_post_type( 'posts' , $args );

	/*register_taxonomy('customers_type',array('customers'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'show_in_nav_menus' => true,
     'rewrite' => array('slug' => 'customers-types', 'with_front' => false),
	 
  ));*/


}





/*-----------------------------------------------------------------------------------*/
/*	When using ACF for header images, remove featured image box from blog posts
/*  http://w4dev.com/wp/remove-featured-image-meta-box/
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_menu' , 'remove_post_thumb_meta_box' );
function remove_post_thumb_meta_box()
{
    global $pagenow, $_wp_theme_features;
    if ( in_array( $pagenow,array('post.php','post-new.php')) && !current_user_can('publish_posts') )
    {
        unset( $_wp_theme_features['post-thumbnails']);
    }
}
?>