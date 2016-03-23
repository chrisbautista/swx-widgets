<?php

/*-----------------------------------------------------------------------------------*/
/*	Social followus Icons
/*-----------------------------------------------------------------------------------*/





function followus($atts, $content = null) {
    extract(shortcode_atts(array(
		"size" => 'short',
    ), $atts));

	if($size != 'short') {

	}


	$path = get_template_directory_uri;

	// Output

	ob_start();

	//
	if($size != 'short') {

	}
	?>

	<div class="social-icons">
		<div class="row">
			<div class="col-xs-2 col-sm-3 col-lg-2">
				<a href="http://www.linkedin.com/company/250145" target="_blank" title="LinkedIn" class="social-icon linkedin">LinkedIn</a>
			</div>
			<div class="col-xs-2 col-sm-3 col-lg-2">
				<a href="https://twitter.com/BDOSolutions" target="_blank" title="Twitter" class="social-icon twitter">Twitter</a>
			</div>
			<div class="col-xs-2 col-sm-3 col-lg-2">
				<a href="https://plus.google.com/111648847568589319031" target="_blank" title="Google Plus" class="social-icon googleplus">Google+</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2 col-sm-3 col-lg-2">
				<a href="http://www.youtube.com/user/myBDOSolutions" target="_blank" title="You Tube" class="social-icon youtube">YouTube</a>
			</div>
			<div class="col-xs-2 col-sm-3 col-lg-2">
				<a href="http://www.facebook.com/BDOCanada?ref=ts" target="_blank" title="Facebook" class="social-icon facebook">Facebook</a>
			</div>
			<div class="col-xs-2 col-sm-3 col-lg-2">
				<a href="#" target="_blank" title="RSS" class="social-icon rss">RSS</a>
			</div>
		</div>
	</div>
	<?
	$output = ob_get_contents();
	ob_end_clean();
	return $output;


}
add_shortcode("followus", "followus");


?>