<?php

function acf_buttons($field = 'buttons') {

	// check if the nested repeater field has rows of data
	if( have_rows($field) ):?>
		<div class="btn-group" role="group" aria-label="...">
			<?php // loop through the rows of data
			while ( have_rows($field) ) : the_row();

				// button
				echo '<a href="' . get_sub_field('link') . '" class="btn btn-lg ' . get_sub_field('css_class') . ' ' . get_sub_field('css_predefined_style') .'" id="' . get_sub_field('css_id') . '">' . get_sub_field('label') . '</a>';		
				
			endwhile; ?>

		</div>

	<?php endif;
}


function why_us() { 
	// check for page specific overrides, pull defaults if it doesn't exist
	$headline = check_acf_field('why_us_headline');
	$copy = check_acf_field('why_us_copy');
?>


	<?php // break out of container  ?>

			</div><!-- col 12 -->
		</div><!-- container -->
	</div><!-- row -->

	<div class="why-box">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4><?php echo $headline; ?></h4>
					<p><?php echo $copy; ?></p>
				</div>
			</div>
		</div>
	</div>

	<?php // reopen container  ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
<?php
}

function speak_to_expert() { 

	// check for page specific overrides, pull defaults if it doesn't exist
	$headline = check_acf_field('speak_to_the_expert_headline','headline');
	$copy = check_acf_field('speak_to_the_expert_copy','copy');
	$link = check_acf_field('speak_to_the_expert_link','link');
	$phone = check_acf_field('speak_to_the_expert_phone','phone');
	$image = check_acf_field('speak_to_the_expert_image','image')

?>

	<div class="row cta-box">
		<div class="col-md-12">
		
			<h4><?php echo $headline; ?></h4>
			
			<div class="row">
			
				<div class="col-md-2">
					<?php ;
					if( !empty($image) ): ?>

						<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="img-responsive" />

					<?php endif; ?>				
				</div>

				<div class="col-md-7 col-xs-12">
					<p><?php echo $copy; ?></p>
				</div>

				<div class="col-md-3 col-xs-12">
					<p><a class="btn btn-custom" role="button" href="<?php echo $link; ?>"><?php echo $phone; ?></a></p>

					<p><a class="btn btn-custom" role="button" href="<?php echo $link; ?>">Send an Inquiry</a></p>					
				</div>
				
			</div>
		</div>
	</div>

<?php
}

?>