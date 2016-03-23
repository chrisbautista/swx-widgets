<?php

/*-----------------------------------------------------------------------------------*/
/*	Add custom post type for Staff staff_testimonials
/*-----------------------------------------------------------------------------------*/

add_action('init', 'staff_testimonials_register');
 
function staff_testimonials_register() {
 
	$labels = array(
		'name' => _x('Staff Testimonials', 'post type general name'),
		'singular_name' => _x('Testimonial', 'post type singular name'),
		'add_new' => _x('Add New', 'Testimonial'),
		'add_new_item' => __('Add New Testimonial'),
		'edit_item' => __('Edit Testimonial'),
		'new_item' => __('New Testimonial'),
		'view_item' => __('View Testimonial'),
		'search_items' => __('Search Testimonial'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => plugins_url( '/images/icons/thumb-up.png', dirname(__FILE__) ), 
		'rewrite' => array('with_front' => false, 'slug' => 'staff_testimonials'),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail','slug')
	  ); 
 
	register_post_type( 'staff_testimonials' , $args );
}



// Show Meta-Box for staff_testimonials

add_action( 'admin_init', 'staff_testimonials_create' );
 
function staff_testimonials_create() {
    add_meta_box('staff_testimonials_meta', 'staff_testimonials', 'staff_testimonials_meta', 'staff_testimonials','normal','high');
}
 
function staff_testimonials_meta () {
	 
	// - grab data -
	 
	global $post;	
	$custom = get_post_custom($post->ID);
	$meta_quote = $custom["staff_testimonials_quote"][0];
	$meta_fullname = $custom["staff_testimonials_fullname"][0];
	$meta_job_title = $custom["staff_testimonials_job_title"][0];
	$meta_company = $custom["staff_testimonials_company"][0];
	$meta_city = $custom["staff_testimonials_city"][0];
	$meta_state = $custom["staff_testimonials_state"][0];
	$meta_year = $custom["staff_testimonials_year"][0];
	$meta_link = $custom["staff_testimonials_link"][0];
	$meta_link_copy = $custom["staff_testimonials_link_copy"][0];
	 
	// - security -
	 
	echo '<input type="hidden" name="staff_testimonials-nonce" id="staff_testimonials-nonce" value="' .
	wp_create_nonce( 'staff_testimonials-nonce' ) . '" />';
	 
	// - output -
	 
	?>
	<div class="meta-box staff_testimonials-meta">
	<ul>
		<li><label>Quotation: </label><textarea name="staff_testimonials_quote"><?php echo $meta_quote; ?></textarea><strong>Do not include quotation marks.</strong></li>
		<li><label>Full Name: </label><input name="staff_testimonials_fullname" value="<?php echo $meta_fullname; ?>" />  <em>(optional)</em></li>
		<li><label>Job Title: </label><input name="staff_testimonials_job_title" value="<?php echo $meta_job_title; ?>" />  <em>(optional)</em></li>
		<li><label>School: </label><input name="staff_testimonials_company" value="<?php echo $meta_company; ?>" / > <em>(optional)</em></li>
		<li><label>Graduation Year: </label><input name="staff_testimonials_year" value="<?php echo $meta_year; ?>" / > <em>(optional)</em></li>
		<li><label>City: </label><input name="staff_testimonials_city" value="<?php echo $meta_city; ?>" / > <em>(optional)</em></li>
		<li><label>State: </label><input name="staff_testimonials_state" value="<?php echo $meta_state; ?>" / > <em>(optional)</em></li>
		<li><label>Link: </label><input name="staff_testimonials_link" value="<?php echo $meta_link; ?>" size="100" /> <em>(optional)</em></li>
		<li><label>Link Copy: </label><input name="staff_testimonials_link_copy" value="<?php echo $meta_link_copy; ?>"  /> <em>(optional)</em></li>
	</ul>
	</div>
	
	<?php
}

// Save Data
 
add_action ('save_post', 'save_staff_testimonials');
 
function save_staff_testimonials(){
	 
	global $post;
	 
	// - still require nonce
	 
	if ( !wp_verify_nonce( $_POST['staff_testimonials-nonce'], 'staff_testimonials-nonce' )) {
		return $post->ID;
	}
	 
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
	 
	// - update post
	 

	if(!isset($_POST["staff_testimonials_quote"])):
	return $post;
	endif;
	$staff_testimonials_quote = $_POST["staff_testimonials_quote"];
	update_post_meta($post->ID, "staff_testimonials_quote", $staff_testimonials_quote );
	 
	if(!isset($_POST["staff_testimonials_fullname"])):
	return $post;
	endif;
	$staff_testimonials_fullname = $_POST["staff_testimonials_fullname"];
	update_post_meta($post->ID, "staff_testimonials_fullname", $staff_testimonials_fullname );
	 
	if(!isset($_POST["staff_testimonials_job_title"])):
	return $post;
	endif;
	$staff_testimonials_job_title = $_POST["staff_testimonials_job_title"];
	update_post_meta($post->ID, "staff_testimonials_job_title", $staff_testimonials_job_title );

	if(!isset($_POST["staff_testimonials_year"])):
	return $post;
	endif;
	$staff_testimonials_year = $_POST["staff_testimonials_year"];
	update_post_meta($post->ID, "staff_testimonials_year", $staff_testimonials_year );
	
	if(!isset($_POST["staff_testimonials_company"])):
	return $post;
	endif;
	$staff_testimonials_company = $_POST["staff_testimonials_company"];
	update_post_meta($post->ID, "staff_testimonials_company", $staff_testimonials_company );

	if(!isset($_POST["staff_testimonials_city"])):
	return $post;
	endif;
	$staff_testimonials_city = $_POST["staff_testimonials_city"];
	update_post_meta($post->ID, "staff_testimonials_city", $staff_testimonials_city );

	if(!isset($_POST["staff_testimonials_state"])):
	return $post;
	endif;
	$staff_testimonials_state = $_POST["staff_testimonials_state"];
	update_post_meta($post->ID, "staff_testimonials_state", $staff_testimonials_state );
	
	if(!isset($_POST["staff_testimonials_link"])):
	return $post;
	endif;
	$staff_testimonials_link = $_POST["staff_testimonials_link"];
	update_post_meta($post->ID, "staff_testimonials_link", $staff_testimonials_link );
	 
	if(!isset($_POST["staff_testimonials_link_copy"])):
	return $post;
	endif;
	$staff_testimonials_link_copy = $_POST["staff_testimonials_link_copy"];
	update_post_meta($post->ID, "staff_testimonials_link_copy", $staff_testimonials_link_copy );
 
}



// styles for admin
 
function staff_testimonials_styles() {
    global $post_type;
    if( 'staff_testimonials' != $post_type )
        return;
    wp_enqueue_style('staff_testimonials_style', plugins_url( '/css/meta.css', dirname(__FILE__) ));
}
 
add_action( 'admin_print_styles-post.php', 'staff_testimonials_styles', 1000 );
add_action( 'admin_print_styles-post-new.php', 'staff_testimonials_styles', 1000 );




//***********************************************************************************

/*
 * staff_testimonials SHORTCODES (CUSTOM POST TYPE)
 * http://www.noeltock.com/web-design/wordpress/how-to-custom-post-types-for-events-pt-2/
 * [events-full]
 */

// 1) FULL EVENTS
//***********************************************************************************

function staff_testimonials ( $atts ) {

	// - define arguments -
	extract(shortcode_atts(array(
		'limit' => '99', // # of events to show
		'id' => '0', 
		'style' => '1', 
		'post_type' => 'staff_testimonials', 
		'orderby'=>'rand'
	 ), $atts));

	// ===== OUTPUT FUNCTION =====

	ob_start();

	// ===== LOOP: FULL EVENTS SECTION =====
	
	// - query -
	$custom_posts = new WP_Query();
	// if id not specified, random
	if($id == 0) { 
		$custom_posts->query('post_type='.$post_type.'&posts_per_page='.$limit.'&orderby=rand');
	} else { 
		$custom_posts->query('post_type='.$post_type.'&posts_per_page=1&p='.$id);
	}
	if ( $custom_posts->have_posts() ) {
		while ($custom_posts->have_posts()) : $custom_posts->the_post();

				// - custom variables -			
				$staff_testimonials_quote = get_post_meta( $custom_posts->post->ID, 'staff_testimonials_quote', true );
				$staff_testimonials_fullname = get_post_meta( $custom_posts->post->ID, 'staff_testimonials_fullname', true );
				$staff_testimonials_job_title = get_post_meta( $custom_posts->post->ID, 'staff_testimonials_job_title', true );
				$staff_testimonials_company = get_post_meta( $custom_posts->post->ID, 'staff_testimonials_company', true );
				$staff_testimonials_year = get_post_meta( $custom_posts->post->ID, 'staff_testimonials_year', true );
				$staff_testimonials_city = get_post_meta( $custom_posts->post->ID, 'staff_testimonials_city', true );
				$staff_testimonials_state = get_post_meta( $custom_posts->post->ID, 'staff_testimonials_state', true );
				$staff_testimonials_link = get_post_meta( $custom_posts->post->ID, 'staff_testimonials_link', true );
				$staff_testimonials_link_copy = get_post_meta( $custom_posts->post->ID, 'staff_testimonials_link_copy', true );
				if (strlen($staff_testimonials_link) > 0 ) $staff_testimonials_link_copy = 'Learn More';

				
				/*
				<div class="full-staff_testimonials">
					<div class="quote">
						<?php echo $staff_testimonials_quote; ?></>
					</div>
					<?php 
					if ((isset($staff_testimonials_fullname)) || (isset($staff_testimonials_job_title)) || (isset($staff_testimonials_company)) || (isset($staff_testimonials_city))) {
						echo '<ul class="quote-author">';
						if (strlen($staff_testimonials_fullname) > 0) echo '<li>'.$staff_testimonials_fullname.'</li>';
						if (strlen($staff_testimonials_job_title) > 0) echo '<li>'.$staff_testimonials_job_title.'</li>';
						if (strlen($staff_testimonials_company) > 0) echo '<li>'.$staff_testimonials_company.'</li>';
						if (strlen($staff_testimonials_city) > 0) echo '<li>'.$staff_testimonials_city.', '.$staff_testimonials_state.'</li>';
						echo '</ul>';
					}
					if (strlen($staff_testimonials_link) > 0) echo '<div class="testimonial button"><a href="'.$staff_testimonials_link.'">'.$staff_testimonials_link_copy.'</a></div>';
					?>
				</div>
				*/				
				
				?>
			
				<blockquote class="well">
					<p>
						&ldquo; <?php echo $staff_testimonials_quote; ?> &rdquo;
					</p>
					<?php 
					if ((isset($staff_testimonials_fullname)) || (isset($staff_testimonials_job_title)) || (isset($staff_testimonials_company)) || (isset($staff_testimonials_city))) {
						echo '<cite  class="align-right">';
						if (strlen($staff_testimonials_fullname) > 0) echo ''.$staff_testimonials_fullname.'';
						if (strlen($staff_testimonials_job_title) > 0) echo ', '.$staff_testimonials_job_title.'';
						echo " at Rand Group"; 
						if (strlen($staff_testimonials_company) > 0) echo '<br/>'.$staff_testimonials_company.'';
						if (strlen($staff_testimonials_year) > 0) echo ', Class of '.$staff_testimonials_year.'';
						// if (strlen($staff_testimonials_city) > 0) echo '  ('.$staff_testimonials_city.', '.$staff_testimonials_state.')';
						echo ' &mdash; </cite>';
					}
					if (strlen($staff_testimonials_link) > 0) echo '<a class="pull-left" href="'.$staff_testimonials_link.'">'.$staff_testimonials_link_copy.'</a>';
					?>
				</blockquote>
				
					



		<?php
		endwhile; 
		} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	
	


	// ===== RETURN: FULL staff_testimonials SECTION =====

	$output = ob_get_contents();
	ob_end_clean();
	return $output; 
	
}

add_shortcode('staff_testimonials', 'staff_testimonials'); // You can now call onto this shortcode with [events-full limit='20']




?>