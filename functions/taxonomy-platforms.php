<?php
if(!is_taxonomy_defined('platforms')) die();
/**
 * Custom Taxonomy Platform
 *
 * @package /swx_widgets/
 * @author 
 */
class CLASS_Taxonomy_Platform
{
    function __construct()
    {
    		add_action( 'init',array($this,'platforms'), 0 );
    }

	// Register Custom Taxonomy
	function platforms() {
		global $enabled_taxonomies;

		$labels = array(
			'name'                       => _x( 'Platforms', 'Taxonomy General Name', 'swx_widgets' ),
			'singular_name'              => _x( 'Platform', 'Taxonomy Singular Name', 'swx_widgets' ),
			'menu_name'                  => __( 'Platforms', 'swx_widgets' ),
			'all_items'                  => __( 'All Platforms', 'swx_widgets' ),
			'parent_item'                => __( 'Parent Platform', 'swx_widgets' ),
			'parent_item_colon'          => __( 'Parent Platform:', 'swx_widgets' ),
			'new_item_name'              => __( 'New Platform Name', 'swx_widgets' ),
			'add_new_item'               => __( 'Add New Platform', 'swx_widgets' ),
			'edit_item'                  => __( 'Edit Platform', 'swx_widgets' ),
			'update_item'                => __( 'Update Platform', 'swx_widgets' ),
			'view_item'                  => __( 'View Platform', 'swx_widgets' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'swx_widgets' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'swx_widgets' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'swx_widgets' ),
			'popular_items'              => __( 'Popular Platforms', 'swx_widgets' ),
			'search_items'               => __( 'Search Platforms', 'swx_widgets' ),
			'not_found'                  => __( 'Not Found', 'swx_widgets' ),
			'no_terms'                   => __( 'No items', 'swx_widgets' ),
			'items_list'                 => __( 'Platforms list', 'swx_widgets' ),
			'items_list_navigation'      => __( 'Platforms list navigation', 'swx_widgets' ),
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

		register_taxonomy( 'platforms', $enabled_taxonomies['platforms']['post_types'], $args );

	}


}

new CLASS_Taxonomy_Platform();