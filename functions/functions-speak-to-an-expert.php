<?php

/*-----------------------------------------------------------------------------------*/
/*	Expert Shortcode
/*-----------------------------------------------------------------------------------*/

function tz_expert( $atts, $content) {
   extract(shortcode_atts(array(
		"headline" => 'default',
		"cta_url" => '/ca/contact/'
    ), $atts));

	// don't use contractor, admin, colin, jason, brandee, bryan
	$exclude_list = array('admin','salesworks','colin','jcarroll','bbarker','bvillanueva','odesk');

	// get expert from post author
	$title = get_the_title();

	$custom_headline = $headline;

	$default_headline = 'Talk to the '.$title.' Expert:';


	// get author info
	$user_id = get_the_author_meta( 'ID' );

	$avatar = get_avatar( get_the_author_meta( 'ID' ), '200' );

	$user_login = get_the_author_meta( 'user_login' );

	$display_name = get_the_author_meta( 'display_name' );

	$user_firstname = get_the_author_meta( 'user_firstname' );

	$job_title = get_the_author_meta( 'job_title' );

	$author_description = get_the_author_meta( 'description' );

	$author_first_name = get_the_author_meta( 'first_name' );

	$author_phone = get_the_author_meta( 'phone' );

	$live_avatar = get_the_author_meta( 'live_avatar' );





	// CTA button
	$form = '[pardot form_url="http://www2.randgroup.com/l/20752/2013-06-19/j19m" width="380" height="450"]';
	// CTA phone
	if (strlen($author_phone) > 2) { 
		$cta_phone = ' or <strong>Call '.$author_phone.'</strong>';
	}
	
	

	/*$cta = '<p><a class="btn-primary btn" href="/contact/#expert=' . $user_login . '" data-toggle="modal">Send a Message</a><p>';*/
	$cta = '<p><a class="btn btn-cta" href="'.$cta_url.'" >Ask '.$user_firstname.' a Question</a>'.$cta_phone.'<p>';
/*
// end modal / squeeze customizations

	$modal = '
	<!-- Modal -->
	<div id="sendMessage" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Send a Message</h3>
	  </div>
	  <div class="modal-body">
		'.do_shortcode( $form ).'
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	  </div>
	</div>';
	// CTA form

//**
// SQUEEZE section
//**
// squeeze form - 7 mistakes
	$squeeze_form = '[pardot form_url=
	"http://www2.randgroup.com/l/20752/2013-05-24/crmr" width="230" height="285" redirect_to="http%3A%2F%2Fwww.randgroup.com%2Fresource-download%2F1&amp;offer_name=7+Software+Selection+Mistakes+That+Spell+Failure&modal=true" ]';

// squeeze page modal - 7 mistakes
	$squeeze = '
  <!-- Squeeze Modal -->
  <div class="modal fade" id="squeezeModal" tabindex="-1" role="dialog" aria-labelledby="squeezeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h3 id="myModalLabel">Recommended For You</h3>
        </div>
	  <div class="modal-body">
			<div id="modal-contents" class="row-fluid" style="display:none;">
				<div class="span6">
			<p><img src="http://www.randgroup.com/wp-content/uploads/downloads/thumbnails/2013/05/7software-selection-screen-200.png"></p>
			<p><strong>"7 Software Selection Mistakes That Spell Failure"</strong> - Software selection is an important decision. This guide will ensure you don’t make the wrong one.</p>
				</div>
				<div class="span6">
				<p>Fill out the form to access this resource:</p>
					'.do_shortcode( $squeeze_form ).'
				</div>
			</div>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->';


  // squeeze form - what are you looking for
//	$squeeze_form = '[pardot form_url="http://www2.randgroup.com/l/20752/2013-09-30/56dj5" width="380" height="250"]';


// squeeze page modal - what are you looking for
//	$squeeze = '
//  <!-- Squeeze Modal -->
  //<div class="modal fade" id="squeezeModal" tabindex="-1" role="dialog" aria-labelledby="squeezeModalLabel" aria-hidden="true">
    //<div class="modal-dialog">
      //<div class="modal-content">
        //<div class="modal-header">
          //<button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  //<h3 id="myModalLabel">What are you looking for today?</h3>

//        </div>
	  //<div class="modal-body">
		//<p>Send us your comments and we\'ll reply back with answers. </p>
		//'.do_shortcode( $squeeze_form ).'
	  //</div>
	  //<div class="modal-footer">
//		<button class="btn modal-close" data-dismiss="modal" aria-hidden="true">Close</button>
        //</div>
      //</div><!-- /.modal-content -->
    //</div><!-- /.modal-dialog -->
  //</div><!-- /.modal -->';


  $squeeze_js ="
  <script>
	jQuery(document).ready(function () {

	// if squeeze modal is closed, don't show it again
	// tbd

	// if visitor is from PPC (cpc) then show them the squeeze
	if(medium == 'cpc') {

			// debug
			// alert('yes');

			setTimeout(function() {

				jQuery('#modal-contents').show();
				jQuery('#squeezeModal').modal('show');

			}, 10000); // milliseconds

		} else {

			// debug
			// alert('no');

		}

	});
  </script>";

 // end modal / squeeze customizations
 */


	// if the author name doesnt match the exclude list
	if(!in_array($user_login, $exclude_list)){

		// show live avatar instead if it exists
		if(strlen($live_avatar) >2) {
			$avatar = '<img alt="'.$display_name.'" src="'.$live_avatar.'" class="avatar pull-left media-object img-responsive photo" height="96" width="96">';
		}

	// if no custom headline specified, use default
	if($custom_headline != 'default') {
			$copy_headline = $custom_headline;
		} else {
			$copy_headline = $default_headline;
		}

	$author_posts = get_related_author_posts();


		$return = '



		<!-- Speak To Expert -->
		<div class="row speak-to-expert">
			<div class="section-tabs">
				<div class="col-sm-offset-1 col-sm-10 col-xs-12">
					<ul id="myTab" class="nav nav-tabs">
		                <li class="active"><a href="#speak-tab" data-toggle="tab">'.$copy_headline.'</a></li>'
?>
<?php
	if ( !empty($author_posts) )	{
		$return .= '	<li><a href="#insight-tab" data-toggle="tab">Latest Insight</a></li>';
	}
?>
<?php
		$return .= '

		            </ul>
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane fade in active" id="speak-tab">
							<div id="speak-to-expert" class="row">
								<div class="photo col-sm-3">
									'.$avatar.'
								</div>
								<div class="expert col-sm-9">
									<h4>'.$display_name.' <br><small>'.$job_title.'</small></h4>
									<p>'.$author_description.'</p>
									'.$cta.'
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="insight-tab">
							<div class="row">
								<div class="news-item expert-news">
									'.$author_posts.'
								</div>
							</div>
						</div>
					</div>
					<!-- /#myTabContent -->
				</div>
			</div>
	</div><!-- // row -->';

	// tab 2

	// latest posts by author id = x
    // $user_id
	// http://www.wpbeginner.com/wp-tutorials/how-to-display-related-posts-by-same-author-in-wordpress/





	// if ppc, squeeze them
	// for testing
	//if ( is_user_logged_in() ) {
	$return .= $squeeze.$squeeze_js;
	//}
	return $return;

	}

}


add_shortcode('expert', 'tz_expert');


?>