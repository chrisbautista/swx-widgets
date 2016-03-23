<?php

/*-----------------------------------------------------------------------------------*/
/*	Add custom post type for Awards Pages
/*-----------------------------------------------------------------------------------*/

add_action('init', 'awards_register');
function awards_register() {
	$args = array(
		'label' => __('Awards'),
		'singular_label' => __('Awards'),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_icon' => plugins_url( '/images/icons/award_star_silver_3.png', dirname(__FILE__) ),
		'rewrite' => array('with_front' => false, 'slug' => 'awards'),
		'has_archive' => false,
		'supports' => array('title', 'editor', 'thumbnail')
		//'taxonomies' => array('category', 'post_tag')
	);
	register_post_type( 'awards' , $args );
}

// Show Meta-Box for Awards

add_action( 'admin_init', 'awards_create' );

function awards_create() {
    add_meta_box('awards_meta', 'Awards', 'awards_meta', 'awards','normal','high');
}

function awards_meta () {

	// - grab data -

	global $post;
	$custom = get_post_custom($post->ID);
	$awards_url = $custom["awards_url"][0];
	$awards_url_copy = $custom["awards_url_copy"][0];

	// - security -

	echo '<input type="hidden" name="awards-nonce" id="awards-nonce" value="' .
	wp_create_nonce( 'awards-nonce' ) . '" />';

	// - output -


	?>
	<div class="meta-box awards-meta">
	<ul>
		<li><label>Link to: </label><input name="awards_url" value="<?php echo $awards_url; ?>" size="100" /> <em>(optional)</em></li>
		<li><label>Link Anchor Text: </label><input name="awards_url_copy" value="<?php echo $awards_url_copy; ?>" size="100" /> <em>(optional)</em></li>
	</ul>
	</div>

	<?php

}

// Save Data

add_action ('save_post', 'save_awards');

function save_awards(){

	global $post;

	// - still require nonce

	if ( !wp_verify_nonce( $_POST['awards-nonce'], 'awards-nonce' )) {
		return $post->ID;
	}

	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;


	if(!isset($_POST["awards_url"])):
	return $post;
	endif;
	$awards_url = $_POST["awards_url"];
	update_post_meta($post->ID, "awards_url", $awards_url );

	if(!isset($_POST["awards_url_copy"])):
	return $post;
	endif;
	$awards_url_copy = $_POST["awards_url_copy"];
	update_post_meta($post->ID, "awards_url_copy", $awards_url_copy );


}



//***********************************************************************************

/*
 * awards SHORTCODES (CUSTOM POST TYPE)
 * http://www.noeltock.com/web-design/wordpress/how-to-custom-post-types-for-awards-pt-2/
 * [awards]
 */

// 1) FULL awards
//***********************************************************************************

function awards ( $atts ) {

	// - define arguments -
	extract(shortcode_atts(array(
		'limit' => '10', // # of awards to show
		'id' => '0',
		'post_type' => 'awards',
		// 'orderby'=>'rand',
		'style' => 'default',
	 ), $atts));

	// ===== OUTPUT FUNCTION =====
	ob_start();

	// - query -
	$custom_posts = new WP_Query();
	if($id == 0) {
		$custom_posts->query('post_type='.$post_type.'&posts_per_page='.$limit);
	} else {
		$custom_posts->query('post_type='.$post_type.'&posts_per_page=1&p='.$id);
	}
	if ( $custom_posts->have_posts() ) {
		echo '<div class="awards-list list '.$style.'">';
		$i = 0;
		while ($custom_posts->have_posts()) : $custom_posts->the_post();
			$content = get_the_content();
			$title = get_the_title();
			// - custom variables -
			$awards_url = get_post_meta( $custom_posts->post->ID, 'awards_url', true );
			$awards_url_copy = get_post_meta( $custom_posts->post->ID, 'awards_url_copy', true );
			if ( strlen($awards_url_copy) === 0 ) { $awards_url_copy = 'More Info'; }

			// styling
			if($style == 'inline') {

				?>
				<div class="row light-grey award">
					<div class="col-sm-3 col-md-3 col-lg-3 award-image">
						<?php if ( has_post_thumbnail()) : ?>
							<?php if ( strlen( $awards_url) > 0 ) {
								echo '<a href="'.$awards_url.'" class="img-responsive no-border">';
							}?>
							<?php the_post_thumbnail('category-thumb-alt', array( 'class'	=> "img-responsive award")); ?>
							<?php if ( strlen( $awards_url) > 0 ) {
								echo '</a>';
							}?>
						<?php endif; ?>
					</div>
					<div class="col-sm-9 col-md-9 col-lg-9 description">
						<h3><?php echo $title; ?></h3>
						<?php echo '<p>'.$content.'</p>'; ?>
						<?php if ( strlen( $awards_url) > 0 ) {
							echo '<p><a class="btn btn-primary" href="'.$awards_url.'">';
							echo $awards_url_copy;
							echo '</a></p>';
						}?>

					</div>
				</div>

				<?php
			} else {
				// default style
				if($i>0) { echo '<div class="divideline"></div>'; }
				$i++;

				?>
				<div class="row-fluid">
					<div class="span4">
						<?php if ( has_post_thumbnail()) : ?>
							<?php if ( strlen( $awards_url) > 0 ) {
								echo '<a href="'.$awards_url.'" class="no-border">';
							}?>
							<?php the_post_thumbnail('medium ', array( 'class'	=> "img-responsive award")); ?>
							<?php if ( strlen( $awards_url) > 0 ) {
								echo '</a>';
							}?>
						<?php endif; ?>
					</div>
					<div class="span8">
						<h3><?php echo $title; ?></h3>
						<?php echo '<p>'.$content.'</p>'; ?>
						<?php if ( strlen( $awards_url) > 0 ) {
							echo '<p><a class="btn" href="'.$awards_url.'">';
							echo $awards_url_copy;
							echo '</a></p>';
						}?>

					</div>
				</div>

				<?php

			}



		endwhile;
		echo '</div>';


	} else {
		// no posts found
		echo "<p></p>";
	}
	/* Restore original Post Data */
	wp_reset_postdata();




	// ===== RETURN: FULL careers SECTION =====

	$output = ob_get_contents();
	ob_end_clean();
	return $output;

}

add_shortcode('awards', 'awards'); // You can now call onto this shortcode with [awards limit='20']


//***********************************************************************************

/*
 * awards triple icon
 * http://www.noeltock.com/web-design/wordpress/how-to-custom-post-types-for-awards-pt-2/
 * [awards]
 */

// [awards3 id1="10181" id2="9958" id3="10178"]
//
//***********************************************************************************

function awards3 ( $atts ) {

	// - define arguments -
	extract(shortcode_atts(array(
		'limit' => '3', // # of awards to show
		'id1' => '0',
		'id2' => '0',
		'id3' => '0',
		'post_type' => 'awards',
		// 'orderby'=>'rand',
		'style' => 'default',
	 ), $atts));

	// ===== OUTPUT FUNCTION =====
	ob_start();

	// - query -


	$args = array(
        //'post__in' => array($id1, $id2, $id3)
		'post__in' => array(10181, 9958, 10178)
	);

	$custom_posts = new WP_Query($args);

	if ( $custom_posts->have_posts() ) {
		echo '<div class="awards-list list '.$style.'">';
		$i = 0;
		while ($custom_posts->have_posts()) : $custom_posts->the_post();
			$content = get_the_content();
			$title = get_the_title();
			// - custom variables -
			$awards_url = get_post_meta( $custom_posts->post->ID, 'awards_url', true );
			$awards_url_copy = get_post_meta( $custom_posts->post->ID, 'awards_url_copy', true );
			if ( strlen($awards_url_copy) === 0 ) { $awards_url_copy = 'More Info'; }

			// styling
			if($style == 'inline') {

				?>
				<div class="row-fluid award">
					<div class="span4">
						<?php if ( has_post_thumbnail()) : ?>
							<?php if ( strlen( $awards_url) > 0 ) {
								echo '<a href="'.$awards_url.'" class="no-border">';
							}?>
							<?php the_post_thumbnail('medium'); ?>
							<?php if ( strlen( $awards_url) > 0 ) {
								echo '</a>';
							}?>
						<?php endif; ?>
					</div>
					<div class="span8">
						<h3><?php echo $title; ?></h3>
						<?php echo '<p>'.$content.'</p>'; ?>
						<?php if ( strlen( $awards_url) > 0 ) {
							echo '<p><a class="btn" href="'.$awards_url.'">';
							echo $awards_url_copy;
							echo '</a></p>';
						}?>

					</div>
				</div>

				<?php
			} else {
				// default style
				if($i>0) { echo '<div class="divideline"></div>'; }
				$i++;

				?>
				<div class="row-fluid">
					<div class="span4">
						<?php if ( has_post_thumbnail()) : ?>
							<?php if ( strlen( $awards_url) > 0 ) {
								echo '<a href="'.$awards_url.'" class="no-border">';
							}?>
							<?php the_post_thumbnail('medium'); ?>
							<?php if ( strlen( $awards_url) > 0 ) {
								echo '</a>';
							}?>
						<?php endif; ?>
					</div>
					<div class="span8">
						<h3><?php echo $title; ?></h3>
						<?php echo '<p>'.$content.'</p>'; ?>
						<?php if ( strlen( $awards_url) > 0 ) {
							echo '<p><a class="btn" href="'.$awards_url.'">';
							echo $awards_url_copy;
							echo '</a></p>';
						}?>

					</div>
				</div>

				<?php

			}



		endwhile;
		echo '</div>';


	} else {
		// no posts found
		echo "<p></p>";
	}
	/* Restore original Post Data */
	wp_reset_postdata();




	// ===== RETURN: FULL careers SECTION =====

	$output = ob_get_contents();
	ob_end_clean();
	return $output;

}

add_shortcode('awards3', 'awards3'); // You can now call onto this shortcode with [awards3 id1="11" id2="22" id3="33"]




?>