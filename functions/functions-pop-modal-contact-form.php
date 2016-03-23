<?php

/*-----------------------------------------------------------------------------------*/
/*	Pop Modal Contact Form Shortcode
/*-----------------------------------------------------------------------------------*/

function pop_contact( $atts, $content = null) {
extract(shortcode_atts(array(  
        "class" => 'btn-primary',
		"form" => 'http://www2.randgroup.com/l/20752/2013-06-19/j19m',
		"headline" => 'Send a Message'
    ), $atts));  
   
	
	// CTA button
	$form = '[pardot form_url="'.$form.'" width="380" height="450"]';
	$cta = '<p><a class="btn '.$class.'" href="#sendMessage1" data-target="#sendMessage1"data-toggle="modal">'.$headline.'</a><p>';
	$modal = '
	<!-- Modal -->
	<div id="sendMessage1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">'.$headline.'</h3>
	  </div>
	  <div class="modal-body">
		'.do_shortcode( $form ).'
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	  </div>
	</div>';	
	
	
	// CTA form 
	
		$return = $cta.$modal;
			
		return $return;
		
}
			

add_shortcode('contact', 'pop_contact');

?>