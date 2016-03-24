<?php
if(!is_taxonomy_defined('roles')) die();
/**
 * Custom Taxonomy Role
 *
 * @package /swx_widgets/
 * @author 
 */
class CLASS_Taxonomy_Role
{
    function __construct()
    {
    		add_action( 'init',array($this,'roles'), 0 );
    }

	// Register Custom Taxonomy
	function roles() {
		global $enabled_taxonomies;

		$labels = array(
			'name'                       => _x( 'Roles', 'Taxonomy General Name', 'swx_widgets' ),
			'singular_name'              => _x( 'Role', 'Taxonomy Singular Name', 'swx_widgets' ),
			'menu_name'                  => __( 'Roles', 'swx_widgets' ),
			'all_items'                  => __( 'All Roles', 'swx_widgets' ),
			'parent_item'                => __( 'Parent Role', 'swx_widgets' ),
			'parent_item_colon'          => __( 'Parent Role:', 'swx_widgets' ),
			'new_item_name'              => __( 'New Role Name', 'swx_widgets' ),
			'add_new_item'               => __( 'Add New Role', 'swx_widgets' ),
			'edit_item'                  => __( 'Edit Role', 'swx_widgets' ),
			'update_item'                => __( 'Update Role', 'swx_widgets' ),
			'view_item'                  => __( 'View Role', 'swx_widgets' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'swx_widgets' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'swx_widgets' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'swx_widgets' ),
			'popular_items'              => __( 'Popular Roles', 'swx_widgets' ),
			'search_items'               => __( 'Search Roles', 'swx_widgets' ),
			'not_found'                  => __( 'Not Found', 'swx_widgets' ),
			'no_terms'                   => __( 'No items', 'swx_widgets' ),
			'items_list'                 => __( 'Roles list', 'swx_widgets' ),
			'items_list_navigation'      => __( 'Roles list navigation', 'swx_widgets' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);

		register_taxonomy( 'roles', $enabled_taxonomies['roles']['post_types'], $args );

	}


}

new CLASS_Taxonomy_Role();