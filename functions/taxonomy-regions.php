<?php
if(!is_taxonomy_defined('regions')) die();
/**
 * Custom Taxonomy Region
 *
 * @package /swx_widgets/
 * @author 
 */
class CLASS_Taxonomy_Region
{
    function __construct()
    {
    		add_action( 'init',array($this,'regions'), 0 );
    }

	// Register Custom Taxonomy
	function regions() {
		global $enabled_taxonomies;

		$labels = array(
			'name'                       => _x( 'Regions', 'Taxonomy General Name', 'swx_widgets' ),
			'singular_name'              => _x( 'Region', 'Taxonomy Singular Name', 'swx_widgets' ),
			'menu_name'                  => __( 'Regions', 'swx_widgets' ),
			'all_items'                  => __( 'All Regions', 'swx_widgets' ),
			'parent_item'                => __( 'Parent Region', 'swx_widgets' ),
			'parent_item_colon'          => __( 'Parent Region:', 'swx_widgets' ),
			'new_item_name'              => __( 'New Region Name', 'swx_widgets' ),
			'add_new_item'               => __( 'Add New Region', 'swx_widgets' ),
			'edit_item'                  => __( 'Edit Region', 'swx_widgets' ),
			'update_item'                => __( 'Update Region', 'swx_widgets' ),
			'view_item'                  => __( 'View Region', 'swx_widgets' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'swx_widgets' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'swx_widgets' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'swx_widgets' ),
			'popular_items'              => __( 'Popular Regions', 'swx_widgets' ),
			'search_items'               => __( 'Search Regions', 'swx_widgets' ),
			'not_found'                  => __( 'Not Found', 'swx_widgets' ),
			'no_terms'                   => __( 'No items', 'swx_widgets' ),
			'items_list'                 => __( 'Regions list', 'swx_widgets' ),
			'items_list_navigation'      => __( 'Regions list navigation', 'swx_widgets' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               =>true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);

		register_taxonomy( 'regions', $enabled_taxonomies['regions']['post_types'], $args );

	}


}

new CLASS_Taxonomy_Region();