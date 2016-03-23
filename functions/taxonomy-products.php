<?php
if(!is_taxonomy_defined('products')) die();
/**
 * Custom Taxonomy Product
 *
 * @package /swx_widgets/
 * @author 
 */
class CLASS_Taxonomy_Product
{
    function __construct()
    {
    		add_action( 'init',array($this,'products'), 0 );
    }

	// Register Custom Taxonomy
	function products() {
		global $enabled_taxonomies;

		$labels = array(
			'name'                       => _x( 'Products', 'Taxonomy General Name', 'swx_widgets' ),
			'singular_name'              => _x( 'Product', 'Taxonomy Singular Name', 'swx_widgets' ),
			'menu_name'                  => __( 'Products', 'swx_widgets' ),
			'all_items'                  => __( 'All Products', 'swx_widgets' ),
			'parent_item'                => __( 'Parent Product', 'swx_widgets' ),
			'parent_item_colon'          => __( 'Parent Product:', 'swx_widgets' ),
			'new_item_name'              => __( 'New Product Name', 'swx_widgets' ),
			'add_new_item'               => __( 'Add New Product', 'swx_widgets' ),
			'edit_item'                  => __( 'Edit Product', 'swx_widgets' ),
			'update_item'                => __( 'Update Product', 'swx_widgets' ),
			'view_item'                  => __( 'View Product', 'swx_widgets' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'swx_widgets' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'swx_widgets' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'swx_widgets' ),
			'popular_items'              => __( 'Popular Products', 'swx_widgets' ),
			'search_items'               => __( 'Search Products', 'swx_widgets' ),
			'not_found'                  => __( 'Not Found', 'swx_widgets' ),
			'no_terms'                   => __( 'No items', 'swx_widgets' ),
			'items_list'                 => __( 'Products list', 'swx_widgets' ),
			'items_list_navigation'      => __( 'Products list navigation', 'swx_widgets' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);

		register_taxonomy( 'products', $enabled_taxonomies['products']['post_types'], $args );

	}


}

new CLASS_Taxonomy_Product();