<?php
/*-----------------------------------------------------------------------------------*/
/* Created by: Abhishek Arora
/* Dated: 3rd Sept, 2015
/* Custom Shortcode for hubspot CTA 
/* Usage [hubspot id = X]
/*-----------------------------------------------------------------------------------*/

function show_hubspot( $atts ) {
	if( have_rows('ctas','option') ): $i = 1;
	// loop through the rows of data
		while (have_rows('ctas','option')) : the_row(); 
			if($atts['id'] == $i):
				return "<div style='float:left;'><div class='".get_sub_field('css_class')."' id='".get_sub_field('css_id')."'>".get_sub_field('code')."</div></div><div class='clearfix'></div>";
			 endif;
			$i++;
		endwhile;
	endif;
}
add_shortcode('hubspot', 'show_hubspot' );
?>