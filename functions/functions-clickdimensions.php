<?php


/*	 clickdimensions Forms
#################################################################################### */


/*-----------------------------------------------------------------------------------*/
/*	 Enqueue the required utmz, geoip and augment script
/*   Usage: head
/*-----------------------------------------------------------------------------------*/

/*
    <!-- augment data -->
    <script type="text/javascript" src="http://j.maxmind.com/app/geoip.js"></script> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script> 
    <script type="text/javascript" src="http://www.randgroup.com/wp-content/plugins/swx-widgets/js/utmz.js"></script> 
    <script type="text/javascript" src="http://www.randgroup.com/wp-content/plugins/swx-widgets/js/augment.js"></script> 
	http://dev1.bdosolutions.com/ca/wp-content/plugins/swx-widgets/js/augment.js
*/

add_action('wp_footer', 'clickdimensions_scripts');

function clickdimensions_scripts() {


	$file_utmz = plugins_url( 'js/utmz.js', dirname(__FILE__) );
	$file_augment = plugins_url( 'js/augment.js', dirname(__FILE__) );
	
    $echo = '
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="http://j.maxmind.com/app/geoip.js"></script> 
		<script type="text/javascript" src="'.$file_utmz.'"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.min.js"></script>
		<script type="text/javascript" src="'.$file_augment.'"></script>
	 ';

		echo $echo;
}

/*
function load_clickdimensions_scripts() {  

	wp_register_script('geoip', 'http://j.maxmind.com/app/geoip.js', array('jquery'));
	wp_enqueue_script('geoip',array(), 'version', true ); // moves to footer, see http://blog.cloudfour.com/getting-all-javascript-into-the-footer-in-wordpress-not-so-fast-buster/
	//wp_register_script('utmz', 'http://www.dynamics101.com/wp-content/plugins/utmz-geoip/js/utmz.js', array('jquery'));
	wp_register_script('utmz', plugins_url('/js/utmz.js', dirname(__FILE__) ), array('jquery'));
	wp_enqueue_script('utmz',array(), 'version', true );
	//wp_register_script('augment', 'http://www.dynamics101.com/wp-content/plugins/utmz-geoip/js/augment.js', array('jquery'));
	wp_register_script('augment', plugins_url('/js/augment.js', dirname(__FILE__) ), array('jquery'));
	wp_enqueue_script('augment',array(), 'version', true );

}  

add_action('wp_enqueue_scripts', 'load_clickdimensions_scripts');  */



 
/*-----------------------------------------------------------------------------------*/
/*	 Show Iframe Forms
/*   http://www.clickdimensions.com/faqs/forms/populate-hidden-field-on-form-with-name-of-webpage/
/*   Usage: shortcode
/*   Example: [clickdimensions form_url="http://www2.dynamics101.com/l/20752/2013-02-25/68q"]
/*-----------------------------------------------------------------------------------*/

function clickdimensions($atts, $content = null) {  
    extract(shortcode_atts(array(  
        //"form_url" => 'http://analytics.clickdimensions.com/forms/h/aNrb4IXuDEbAAwAhbQT5w',//CD General 
		//"form_url" => 'http://analytics.clickdimensions.com/forms/h/aH5fRTEiGXkmqyRvXleRd5', //CDDT General
		"form_url" => 'http://analytics.clickdimensions.com/forms/h/aFNwjVVWTkeqIV8eGkUNTw',
		"form_template" => 'includes/form.inc.php',
		"type" => 'formcapture', 
		"return_url" => null,
		"size" => 'short',
		"redirect_to" => 'http://'.$_SERVER[HTTP_HOST].'/ca/success/',
		"success_url" => 'http://'.$_SERVER[HTTP_HOST].'/ca/success/',
		"offer_name" => 'Contact Request',
		"offer_category" => 'contact',
		"id" => 'click-dimensions-form'
    ), $atts));  
	
	if($size != 'short') { 
		
	}
	
	if ($_GET['did']) {
		$did = $_GET['did'];
		$redirect_to = '/ca/resource-download/'.$did;
		$redirect_to = 'http://'.$_SERVER['HTTP_HOST'].$redirect_to; 
		//$redirect_to = $success_url.'?redirect_to=http://'.$_SERVER['HTTP_HOST'].$redirect_to; 
		//$redirect_to = urlencode($redirect_to);
		//$redirect_to = 'redirect_to='.$redirect_to;
	} elseif ($_GET['redirect_to']) {
		$redirect_to = $_GET['redirect_to'];
		$redirect_to = 'http://'.$_SERVER['HTTP_HOST'].$redirect_to; 
		//$redirect_to = $success_url.'?redirect_to=http://'.$_SERVER['HTTP_HOST'].$redirect_to;
		//$redirect_to = urlencode($redirect_to);
		//$redirect_to = 'redirect_to='.$redirect_to;
	}elseif(strlen($redirect_to) > 0) {
		$redirect_to = urlencode($redirect_to);
		//$redirect_to = 'redirect_to='.$redirect_to;			
	} 
	
	/*if(strlen($offer_name) > 0) {
		$offer_name = '&offer_name='.urlencode($offer_name);
		$redirect_to .= $offer_name;
	}
	
	if(strlen($offer_category) > 0) {
		$offer_category = '&offer_category='.urlencode($offer_category);
		$redirect_to .= $offer_category;
	}
	*/
	
	
	
    // return '<iframe src="'.$form_url.'?'.$redirect_to.'" url="'.$form_url.'" width="'.$width.'" height="'.$height.'" id="'.$id.'" redirect_to="'.$redirect_to.'" type="text/html" frameborder="0" allowTransparency="true" style="border: 0"></iframe>';
	
	// include form template
	ob_start();
	require_once($form_template);
		
	// return output
	return ob_get_clean();

}  
add_shortcode("clickdimensions", "clickdimensions");  
 
 
 
 
/*-----------------------------------------------------------------------------------*/
/*	 Success Page / Delivery
/*   Usage: shortcode
/*   Example: [success]
/*-----------------------------------------------------------------------------------*/

function successpage($atts, $content = null) {  
    extract(shortcode_atts(array(  
        //"form_url" => 'http://analytics.clickdimensions.com/forms/h/a35TqZuOUyBQJo5p0MVTA',//CD
    ), $atts));  

	// DEBUG 
	/*
	echo "did: ".$did."<br/>";
	echo "name: ".$_SERVER['SERVER_NAME']."<br/>";
	echo "uri: ".$_SERVER['SERVER_URI']."<br/>";
	echo "category: ".$category."<br/>";
	echo "category id: ".$category_id."<br/>";
	echo "redirect url: ".$meta_url."<br/>";
	echo "meta_video_type: ".$$meta_video_type."<br/>";
	
	if(!isset($_COOKIE['haspardot'])) { echo "cookie: no<br/>"; }
	if(isset($_COOKIE['haspardot'])) { echo "cookie: yes<br/>"; }
	*/
	
	// ####################################################### 
	// EVENTS
	// ####################################################### 
	
	// is there an event id
	if(strlen($_GET['id'])>0) {
	
		$event_id =  $_GET['id']; 
		$return = 'true';
		echo "<p>Thank you for registering for our event. Please click below to add an appointment reminder to your calendar.</p>";
		echo event_ical($event_id, $return = 'true');
		
		// echo "<p>Should you have any questions, please <a href=\"mailto:info@randgroup.com?subject=Event ".$event_id ."\">info@randgroup.com</a>.</p>";
		
	
	// ####################################################### 
	// RESOURCE DOWNLOAD
	// ####################################################### 

	// if redirect url detected
	} elseif(strlen($_GET['redirect_to'])>1) {
	
		
		// is url for a video video?
		if($meta_video_type == 1) { 
		
				// echo '<p class="alert alert-success"><strong>Check Your Email.</strong> An email has been sent to the address you provided containing a link to access the requested resource.</p>';

				// ensure the url is publicly accessible 
				// eg: /home/rand/public_html/assets/crm/103854_Virginia_MASTER_MIXED_AUDIO_750k.wmv
				// need to replace internal dirs with http url								
				$home_dir = '/home/bdosolut/public_html/ca/';
				if (strpos($meta_url,$home_dir) !== false) {
					$public_url = "http://".$_SERVER['SERVER_NAME']."/";
					$video_url = str_replace($home_dir,$public_url,$meta_url);
				}
				
				// debug
				// echo "meta_url: ".$meta_url."<br/>";
				// echo "public_url: ".$public_url."<br/>";
				// echo "video_url: ".$video_url."<br/>";
				
				
				// embed with plugin								
				echo do_shortcode('[video src="'.$video_url.'"]');
				
		} else { // if not video
		
				//echo '<div class="row-fluid"><div class="
				echo '<h2>Check Your Email</h2><p class="alert alert-success"><strong>An email has been sent</strong> to the address you provided containing a link to access the requested resource.</p>';
				
				// auto forward the user
				// no longer required, as offer is being sent via email
				
				?>
					<script language="JavaScript" type="text/javascript">  
					var count =30
					var redirect="<?php echo $_GET['redirect_to'];?>"  
					  
					function countDown(){  
					 if (count <=0){  
					  window.location = redirect;  
					 }else{  
					  count--;  
					  document.getElementById("timer").innerHTML = "You will be automatically taken to the resource you requested in "+count+" seconds."  
					  setTimeout("countDown()", 1000)  
					 }  
					}  
					</script>  
					<p><span id="timer"><script>countDown();</script></span><?php echo '<a href="'.$_GET['redirect_to'].'" target="_blank">Continue Immediately</a>'; ?></p>
				<?php
												
			} // end if not video
			
		// tempt the user with more resources from same cat
		
		echo '<div class="row-fluid">';
		echo '<div class="span6">';
		echo '<h4>Recommended Resources</h4>';
		echo '<p>Check out some of our other helpful resources:</p>';
		echo do_shortcode('[downloads format="12" query="limit=3&orderby=rand&category='.$category_id.'"]  ');
		echo '</div>';
		/*<div class="span6">';
		echo '<h4>Rand Group Can Help</h4>';
		echo '<p>One of Rand Group’s key competitive advantages is the matrix of talent employed by the firm. Our knowledge base is unmatched. We are experts in the business management industry with the experience, training and education to deliver world-class results with accuracy and efficiency.</p>';
		echo '<p><a href="/contact/" class="btn">Speak with an Expert</a></p>';
		echo '</div>';*/		
		echo '</div>';
		
		
	// ####################################################### 
	// CONTACT FORM
	// ####################################################### 
		
	} else { // end if redirect url
	
		echo '<p class="alert alert-success"><strong>Thank you for your inquiry.</strong></p>';					
		echo '<p>A representative will be in touch in approximately one business day. </p>';
		echo '<p>&nbsp;</p>';

		echo '<div class="row">';
			echo '<div class="col-lg-12 col-md-12 col-sm-12">';
			echo '<h4>Helpful Guides</h4>';
			echo'<div id="resources">';
			echo do_shortcode('[downloads query="limit=4&orderby=hits&order=desc" format="13"]');
			echo '<p class="ulink"><a href="/ca/resources/">View more resources</a></p>';
			echo '</div>';
		echo '</div>';
		
		/*
		echo '<div class="row">';
		echo '<div class="col-lg-12 col-md-12 col-sm-12">';
		echo '<h4>Latest Insights</h4>';
		?>
		
		<div id="recent-posts-block" class="row-fluid">
			<?php $the_query = new WP_Query( 'showposts=3' ); ?>
			<?php while ($the_query -> have_posts()) : $the_query -> the_post(); 
				$title = get_the_title();
				?>
				<div class="span4 insights-blks">
					<p>
					<a href="<?php the_permalink() ?>" title="<?php echo $title; ?>">
					<img src="<?php get_attachment_picture();?>" alt="<?php the_title_attribute(); ?>" >
					</p> 
					<?php echo neat_trim($title, 45); ?></a>
					<p class="meta"><?php the_time('F j'); ?></p>	
				</div>
			<?php endwhile;?>
		</div><!-- /row -->       
		
		<?php						
		echo '</div>';
		echo '</div>';
		*/
	}
	 

}  
add_shortcode("successpage", "successpage");  

//Enqueue scripts for auto-fill form fields

// function load_scripts() {
	// wp_enqueue_script('jquery');
	// wp_register_script('jq_cookie', plugins_url('js/jquery.cookie.min.js', dirname(__FILE__)), array('jquery'),null, true);
	// wp_enqueue_script('jq_cookie');
	// wp_register_script('form-autofill', plugins_url('js/form-autofill.js', dirname(__FILE__)), array('jq_cookie'),null, true);
	// wp_enqueue_script('form-autofill');
// }    

// add_action('init', 'load_scripts');
 
?>