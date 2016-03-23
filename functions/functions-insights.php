<?php


//***********************************************************************************

/*
 * INSIGHTS SHORTCODE
 * http://www.noeltock.com/web-design/wordpress/how-to-custom-post-types-for-events-pt-2/
 * [insights limit=1 id=1]
 */

// 1) FULL EVENTS
//***********************************************************************************

function insights ( $atts ) {

	// - define arguments -
	extract(shortcode_atts(array(
		'limit' => '10', // # of posts to show
		'id' => '0',
		'style' => 'home',
		'post_type' => 'post',
		'orderby'=>'rand'
	 ), $atts));

	// ===== OUTPUT FUNCTION =====

	ob_start();

	// ===== LOOP: FULL EVENTS SECTION =====

	// - query -
	$custom_posts = new WP_Query();
	// if id not specified, random
	if($id == 0) {
		$custom_posts->query('post_type='.$post_type.'&posts_per_page='.$limit.'&orderby='.$orderby);
	} else {
		$custom_posts->query('post_type='.$post_type.'&posts_per_page=1&p='.$id);
	}
	if ( $custom_posts->have_posts() ) {
		while ($custom_posts->have_posts()) : $custom_posts->the_post();

				// - custom variables -
				if (strlen($insights_link) > 0 ) $insights_link_copy = 'Learn More';


				// copied from content.php
		 ?>
 <article <?php post_class(); ?>>
	<div class="row container-box">
		<div class="col-md-4">
			<?php if ( has_post_thumbnail() ) { ?>
			<?php the_post_thumbnail('medium', array( 'class'	=> "img-responsive")); ?></li>
			<?php } ?>
		</div><!-- //col -->
		<div class="col-md-8">
			<header>
				<?php get_template_part('templates/entry-meta'); ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</header>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-lsretail" role="button">Read More</a>
			</div>
		</div><!-- //col -->
	</div><!-- //row -->
</article>

		 <?php




		endwhile;
		} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();




	// ===== RETURN: FULL insights SECTION =====

	$output = ob_get_contents();
	ob_end_clean();
	return $output;

}

add_shortcode('insights', 'insights'); // You can now call onto this shortcode with [events-full limit='20']




?>