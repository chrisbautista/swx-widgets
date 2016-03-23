<?php

/*-----------------------------------------------------------------------------------*/
/*	Add custom post type for Customers Pages
/*-----------------------------------------------------------------------------------*/

add_action('init', 'customers_register');
function customers_register() {
	$args = array(
		'label' => __('Customers'),
		'singular_label' => __('Customers'),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_rest' => true,
		'query_var' => true,
		'capability_type' => 'page',
		'hierarchical' => false,
		'menu_icon' => plugins_url( '/images/icons/award_star_silver_3.png', dirname(__FILE__) ),
		'rewrite' => array('with_front' => false, 'slug' => 'customers'),
		'has_archive' => true,
		'supports' => array('title', 'editor', 'excerpt','revisions')
		//'taxonomies' => array('category', 'post_tag')
	);
	register_post_type( 'customers' , $args );

}

// change pagination to show all customers
function dj_modify_num_posts_for_customers($query)
{
    //if ($query->is_main_query() && $query->is_post_type_archive('customers') && !is_admin())
        //$query->set('posts_per_page', 1000);
}
 
//add_action('pre_get_posts', 'dj_modify_num_posts_for_customers');

// quote shortcode
// [quote id="2" align="right"]
function quote ( $atts ) {

	// - define arguments -
	extract(shortcode_atts(array(
		'limit' => '1', //
		'id' => '0', 
		'style' => '1', 
		'post_type' => 'testimonials', 
		'align' => 'right',
		'orderby'=>'rand'
	 ), $atts));

	// ===== OUTPUT FUNCTION =====
	ob_start();

	// is there a specific quote to pull?
	if($id == 0) { 
		$row = 0;		
	} else { 
		$row = $id - 1;
	}	
	if($align == 'left') { 
		$css = 'pull-left';
	} else {
		$css = 'pull-right';
	}
											
	
	// pull Quotations repeater values for this post
	// check if the repeater field has rows of data
	if( have_rows('customers_quotations') ): ?>
		<?php // loop through the rows of data
		// show only a specific row
		// https://gist.github.com/wesrice/1924934
		$repeater = get_field( 'customers_quotations' ); 
		// debug
		//echo $repeater[1]['quotation'];
		//echo $repeater[0]['quotation'];
		//echo $repeater[2]['quotation'];
		if (strlen($repeater[$row]['quotation'])>2) { 
			?>
			<div class="quote-inline <?php echo $css; ?>">										
				<?php echo $repeater[$row]['quotation']; ?>
				<p class="text-right">
					<?php if($repeater[$row]['full_name']) { ?>
						- <?php echo $repeater[$row]['full_name']; ?>
					<?php } ?>
					<?php if($repeater[$row]['job_title']) { ?>
						, <?php echo $repeater[$row]['job_title']; ?>
					<?php } ?>					
					<br/><?php the_title(); ?>
				</p>
			</div>	
		<?php } 
	endif;
		

	// ===== RETURN: FULL testimonials SECTION =====

	$output = ob_get_contents();
	ob_end_clean();
	return $output; 
	
}

add_shortcode('quote', 'quote'); // You can now call onto this shortcode with [events-full limit='20']

add_action( 'rest_api_init', 'register_api_custom_fields' );
function register_api_custom_fields() {
    register_api_field( 'customers',
        '_logo',
        array(
            'get_callback'    => 'get_logo',
            'update_callback' => null,
            'schema'          => null,
        )
    );

	register_api_field('customers','country_list',
		array(
			'get_callback' => 'get_country_list_cust',
			'update_callback' => null,
			'schema' => null,
			));

	register_api_field('customers','product_list',
		array(
			'get_callback' => 'get_product_list_cust',
			'update_callback' => null,
			'schema' => null,
			));

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
function get_logo( $object, $field_name, $request ) {
	
    // $image_upload = get_attached_media('image', $object[ 'id' ] );
   //  var_dump($image_upload);

    //return end($image_upload); 
   
	//return get_attachment_image_src();
	 return wp_get_attachment_image(get_post_meta( $object[ 'id' ], 'logo', true ), "full");
}

function get_country_list_cust($object, $field_name, $request) {

	$country_list = array();


	$terms = get_the_terms( $object['id'], 'country' );
	if ( $terms && ! is_wp_error( $terms )  ) {
		foreach ( $terms as $term ) {
			$country_list[] = $term->name;
			$country_slug_list[] = $term->slug;
		}
	}
	$country_list = join( ", ", $country_list);

	
	return $country_list;
}

function get_product_list_cust($object, $field_name, $request) {
	$prod_list = '';
	$prods = get_the_terms( $object['id'], 'product' );

	$prod_list = array();
	
	if ( $prods && ! is_wp_error( $prods  )  ) {
		foreach ( $prods as $prod ) {
			$prod_list[] = $prod->slug;
		}
		$prod_list = join( ", ", $prod_list);
	}

	return $prod_list;
}

?>