<?php

/*-----------------------------------------------------------------------------------*/
/*	Add custom post type for Partners Pages
/*-----------------------------------------------------------------------------------*/

add_action('init', 'partners_register');
function partners_register() {
	$args = array(
		'label' => __('Partners'),
		'singular_label' => __('Partners'),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_rest' => true,
		'query_var' => true,
		'capability_type' => 'page',
		'hierarchical' => false,
		'menu_icon' => plugins_url('/images/icons/award_star_silver_3.png', dirname(__FILE__)),
		'rewrite' => array('with_front' => false, 'slug' => 'partners'),
		'has_archive' => true,
		'exclude_from_search' => true,
		'supports' => array('title', 'revisions'),
		//'taxonomies' => array('category', 'post_tag')
	);
	register_post_type('partners', $args);

}

// change pagination to show all partners
// change default sort order
// http://www.advancedcustomfields.com/resources/orde-posts-by-custom-fields/
function my_pre_get_posts($query) {

	// do not modify queries in the admin
	if (is_admin()) {
		return $query;
	}

	// only modify queries for 'partners' post type
	if (isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'partners') {
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');

		// $query->set('posts_per_page', 23);
		//$query->set('posts_per_page', 1000);

		// Random Ordering
		/*

		$query->set('orderby', 'rand');
		*/
	}
	// return
	return $query;
}

add_action('pre_get_posts', 'my_pre_get_posts');

add_action('rest_api_init', 'register_api_partners_fields');
function register_api_partners_fields() {
	register_api_field('partners',
		'_logo',
		array(
			'get_callback' => 'get_partners_logo',
			'update_callback' => null,
			'schema' => null,
		)
	);

	register_api_field('partners', 'country_list',
		array(
			'get_callback' => 'get_country_list',
			'update_callback' => null,
			'schema' => null,
		));

	register_api_field('partners', 'product_list',
		array(
			'get_callback' => 'get_product_list',
			'update_callback' => null,
			'schema' => null,
		));

	register_api_field('partners', 'partner_level_class',
		array(
			'get_callback' => 'get_partner_level_list',
			'update_callback' => null,
			'schema' => null,
		));

	register_api_field('partners',
		'connect_with_partner_hubspot_landing_page',
		array(
			'get_callback' => 'get_partners_hubspot_landing_page',
			'update_callback' => null,
			'schema' => null,
		)
	);

	register_api_field('partners',
		'partners_email_address',
		array(
			'get_callback' => 'get_partners_email_address',
			'update_callback' => null,
			'schema' => null,
		)
	);

}

/**
 * Get the value of the "starship" field
 *
 * @param array $object Details of current post.
 * @param string $field_name Name of field.
 * @param WP_REST_Request $request Current request
 *
 * @return mixed
 */

function get_partners_logo($object, $field_name, $request) {
	return wp_get_attachment_image(get_post_meta($object['id'], 'logo', true), "full");
}
function get_partners_hubspot_landing_page($object, $field_name, $request) {

	return get_field('connect_with_partner_hubspot_landing_page', 'option', false);
}
function get_partners_email_address($object, $field_name, $request) {
	return get_field('partners_email_address', $object['id'], false);
}

function get_country_list($object, $field_name, $request) {

	$country_list = array();

	$terms = get_the_terms($object['id'], 'country');
	if ($terms && !is_wp_error($terms)) {
		foreach ($terms as $term) {
			$country_list[] = $term->name;
			$country_slug_list[] = $term->slug;
		}
	}
	$country_list = join(", ", $country_list);

	return $country_list;
}

function get_product_list($object, $field_name, $request) {
	$prod_list = '';
	$prods = get_the_terms($object['id'], 'product');

	$prod_list = array();

	if ($prods && !is_wp_error($prods)) {
		foreach ($prods as $prod) {
			$prod_list[] = $prod->slug;
		}
		$prod_list = join(", ", $prod_list);
	}

	return $prod_list;
}

function get_partner_level_list($object, $field_name, $request) {
	$prod_list = '';
	$prods = get_the_terms($object['id'], 'partner_level');

	$prod_list = array();

	if ($prods && !is_wp_error($prods)) {
		foreach ($prods as $prod) {
			$prod_list[] = 'partner-level-' . $prod->slug;
		}
		$prod_list = join(" ", $prod_list);
	}

	return $prod_list;
}

/*

// change pagination to show all partners
// change default sort order
// http://www.advancedcustomfields.com/resources/orde-posts-by-custom-fields/
function my_pre_get_posts( $query ) {

// do not modify queries in the admin
if( is_admin() ) {
return $query;
}

// only modify queries for 'event' post type
if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'partners' ) {
$query->set('posts_per_page', 1000);
$query->set('orderby', 'meta_value');
$query->set('meta_key', 'country'); // this does not work because its a custom taxonomy and appears to be ordering based on the taxonomy ID not the value

$query->set('order', 'ASC');
}
// return
return $query;
}

add_action('pre_get_posts', 'my_pre_get_posts');

// Load our function when hook is set Orderby Partner Title
add_action( 'pre_get_posts', 'rc_modify_query_get_design_projects' );

function rc_modify_query_get_design_projects( $query ) {

// Check if on frontend and main query is modified
if( ! is_admin() && $query->is_main_query() && $query->query_vars['post_type'] != 'partner' ) {

$query->set('orderby', 'title');

$query->set('order', 'ASC');

}

}
 */

?>