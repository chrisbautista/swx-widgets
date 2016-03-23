<?php

/*-----------------------------------------------------------------------------------*/
/*	Add custom post type for Event Pages
/*-----------------------------------------------------------------------------------*/

add_action('init', 'event_register');
function event_register() {
	$args = array(
		'label' => __('Events'),
		'singular_label' => __('Event'),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_icon' => plugins_url( '/images/icons/calendar.png', dirname(__FILE__) ),
		'rewrite' => array('with_front' => false, 'slug' => 'events'),
		'has_archive' => true,
		'supports' => array('title', 'editor', 'thumbnail','excerpt','revisions')
		//'taxonomies' => array('category', 'post_tag')
	);
	register_post_type( 'events' , $args );
}

// Show Meta-Box for Events
/*

add_action( 'admin_init', 'events_create' );
function events_create() {
    add_meta_box('events_meta', 'Events', 'events_meta', 'events','normal','high');
}

function events_meta () {

	// - grab data -

	global $post;
	$custom = get_post_custom($post->ID);
	$meta_sd = $custom["events_startdate"][0];
	$meta_ed = $custom["events_enddate"][0];
	$meta_location = $custom["events_location"][0];
	$meta_address = $custom["events_address"][0];
	$meta_signup = $custom["events_signup"][0];
	$meta_form = $custom["events_form"][0];
	$meta_offer_name = $custom["offer_name"][0];
	$meta_offer_category = $custom["offer_category"][0];
	$meta_redirect_to = $custom["events_redirect_to"][0];
	$meta_directions = $custom["events_directions"][0];
	$meta_st = $meta_sd;
	$meta_et = $meta_ed;

	// - grab wp time format -

	$date_format = get_option('date_format'); // Not required in my code
	//$time_format = get_option('time_format');
	$time_format = 'G:i';
	$time_zone = 'CST';

	// - populate today if empty, 00:00 for time -

	if ($meta_sd == null) { $meta_sd = time(); $meta_ed = $meta_sd; $meta_st = 0; $meta_et = 0;}

	// - convert to pretty formats -

	$clean_sd = date("D, M d, Y", $meta_sd);
	$clean_ed = date("D, M d, Y", $meta_ed);
	$clean_st = date($time_format, $meta_st);
	$clean_et = date($time_format, $meta_et);

	// - security -

	echo '<input type="hidden" name="events-nonce" id="events-nonce" value="' .
	wp_create_nonce( 'events-nonce' ) . '" />';

	// - output -

	?>
	<div class="tf-meta">
	<h4>Event Details</h4>
	<ul>
		<li><label>Start Date </label><input name="events_startdate" class="tfdate" value="<?php echo $clean_sd; ?>" /></li>
		<li><label>Start Time </label><input name="events_starttime" value="<?php echo $clean_st; ?>" /> <em>Use 24h format (7pm = 19:00) CST </em></li>
		<li><label>End Date </label><input name="events_enddate" class="tfdate" value="<?php echo $clean_ed; ?>" /></li>
		<li><label>End Time </label><input name="events_endtime" value="<?php echo $clean_et; ?>" / ><em>Use 24h format (7pm = 19:00) CST</em></li>
		<li><label>Brief Location </label><input name="events_location" value="<?php echo $meta_location; ?>" size="40" /> <em>(optional)</em></li>
		<li><label>Full Address</label><em>(optional)</em><br/><textarea name="events_address" style="width:400px; height:50px;"><?php echo $meta_address; ?></textarea></li>
		<li><label>Directions URL </label><input name="events_directions" value="<?php echo $meta_directions; ?>" size="100" /> <em>(optional)</em></li>
	</ul>
	<h4>Call To Action</h4>
	<ul>
		<li><label>Signup URL </label><input name="events_signup" value="<?php echo $meta_signup; ?>" size="100" /> <em>(optional, external signup url)</em></li>
		<li>OR</li>
		<li><label>Signup FORM </label><input name="events_form" value="<?php echo $meta_form; ?>" size="100" /> <em>(optional ClickDimensions form action URL. http://analytics.clickdimensions.com/forms/h/aiNuvwoy9UqdXwp0DohprQ</em></li>
		<li><label>Signup Success URL </label><input name="events_redirect_to" value="<?php echo $meta_redirect_to; ?>" size="100" /> <em>(optional http://www.bdosolutions.com/ca/success/events/)</em></li>
		<li><label>ClickDimensions - Offer Name: </label><input name="offer_name" value="<?php echo $meta_offer_name; ?>" size="100" /> <em>(Unique identification name for tracking this event) </em></li>
		<li><label>ClickDimensions - Offer Category: </label><input name="offer_category" value="<?php echo $meta_offer_category; ?>" size="100" /> <em>("Microsoft Dynamics GP", "Microsoft CRM", "Microsoft SharePoint", "Manufacturing", etc. Match it to the Download  Monitor categories.</em></li>

	</ul>
	<h4>URLs</h4>
	<ul>
		<li><label>ICS URL</label><?php echo event_ical($post->ID, $return = 'true'); ?> </li>
	</ul>
	</div>

	<?php
}

// Save Data

add_action ('save_post', 'save_events');

function save_events(){

	global $post;

	// - still require nonce

	if ( !wp_verify_nonce( $_POST['events-nonce'], 'events-nonce' )) {
		return $post->ID;
	}

	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// - convert back to unix & update post

	if(!isset($_POST["events_startdate"])):
	return $post;
	endif;
	$updatestartd = strtotime ( $_POST["events_startdate"] . $_POST["events_starttime"] );
	update_post_meta($post->ID, "events_startdate", $updatestartd );

	if(!isset($_POST["events_enddate"])):
	return $post;
	endif;
	$updateendd = strtotime ( $_POST["events_enddate"] . $_POST["events_endtime"]);
	update_post_meta($post->ID, "events_enddate", $updateendd );

	if(!isset($_POST["events_location"])):
	return $post;
	endif;
	$events_location = $_POST["events_location"];
	update_post_meta($post->ID, "events_location", $events_location );

	if(!isset($_POST["events_address"])):
	return $post;
	endif;
	$events_address = $_POST["events_address"];
	update_post_meta($post->ID, "events_address", $events_address );

	if(!isset($_POST["events_signup"])):
	return $post;
	endif;
	$events_signup = $_POST["events_signup"];
	update_post_meta($post->ID, "events_signup", $events_signup );

	if(!isset($_POST["events_form"])):
	return $post;
	endif;
	$events_form = $_POST["events_form"];
	update_post_meta($post->ID, "events_form", $events_form );

	if(!isset($_POST["events_redirect_to"])):
	return $post;
	endif;
	$events_redirect_to = $_POST["events_redirect_to"];
	update_post_meta($post->ID, "events_redirect_to", $events_redirect_to );

	if(!isset($_POST["offer_name"])):
	return $post;
	endif;
	$offer_name = $_POST["offer_name"];
	update_post_meta($post->ID, "offer_name", $offer_name );

	if(!isset($_POST["offer_category"])):
	return $post;
	endif;
	$offer_category = $_POST["offer_category"];
	update_post_meta($post->ID, "offer_category", $offer_category );

	if(!isset($_POST["events_directions"])):
	return $post;
	endif;
	$events_directions = $_POST["events_directions"];
	update_post_meta($post->ID, "events_directions", $events_directions );

}

// JS Datepicker UI

function events_styles() {
    global $post_type;
    if( 'events' != $post_type )
        return;
    wp_enqueue_style('ui-datepicker', plugins_url( '/css/jquery-ui-1.8.9.custom.css', dirname(__FILE__) ));

}

function events_scripts() {
    global $post_type;
    if( 'events' != $post_type )
        return;
	
    wp_enqueue_script('jquery-ui', plugins_url( '/js/jquery-ui-1.8.9.custom.min.js', dirname(__FILE__) ) , array('jquery'));
    wp_enqueue_script('ui-datepicker', plugins_url( '/js/jquery.ui.datepicker.min.js', dirname(__FILE__) ));
    wp_enqueue_script('custom_script', plugins_url( '/js/pubforce-admin.js', dirname(__FILE__) ), array('jquery'));


}

add_action( 'admin_print_styles-post.php', 'events_styles', 1000 );
add_action( 'admin_print_styles-post-new.php', 'events_styles', 1000 );

add_action( 'admin_print_scripts-post.php', 'events_scripts', 1000 );
add_action( 'admin_print_scripts-post-new.php', 'events_scripts', 1000 );

*/


//***********************************************************************************

/*
 * EVENTS SHORTCODES (CUSTOM POST TYPE)
 * http://www.noeltock.com/web-design/wordpress/how-to-custom-post-types-for-events-pt-2/
 * [events style="archive"]
 */

// 1) FULL EVENTS
//***********************************************************************************

function events ( $atts ) {

	// - define arguments -
	extract(shortcode_atts(array(
		'limit' => '10', // # of events to show
		'style' => '1'
	 ), $atts));

	// ===== OUTPUT FUNCTION =====

	ob_start();

	// ===== LOOP: FULL EVENTS SECTION =====

	// - hide events that are older than 6am today (because some parties go past your bedtime) -

	$today6am = strtotime('today 6:00') + ( get_option( 'gmt_offset' ) * 3600 );

	// - query -
	global $wpdb;
	$querystr = "
		SELECT *
		FROM $wpdb->posts wposts, $wpdb->postmeta metastart, $wpdb->postmeta metaend
		WHERE (wposts.ID = metastart.post_id AND wposts.ID = metaend.post_id)
		AND (metaend.meta_key = 'events_enddate' AND metaend.meta_value > $today6am )
		AND metastart.meta_key = 'events_enddate'
		AND wposts.post_type = 'events'
		AND wposts.post_status = 'publish'
		ORDER BY metastart.meta_value ASC LIMIT $limit
	 ";

	$events = $wpdb->get_results($querystr, OBJECT);

	// - declare fresh day -
	$daycheck = null;

	// - loop -
	if ($events) {
		global $post;

		// output
		if( $style != 'archive') { echo  '<ol class="event-list list bigTargetBox">'; }

		foreach ($events as $post):
			setup_postdata($post);

			// - custom variables -
			$custom = get_post_custom(get_the_ID());
			$sd = $custom["events_startdate"][0];
			$ed = $custom["events_enddate"][0];
			$signup = $custom["events_signup"][0];
			$location = $custom["events_location"][0];

			// - determine if it's a new day
			// - and not the "big list" style
			$longdate = date("l, F j, Y", $sd);

			if ($daycheck == null) { $edate = '<h4>' . $longdate . '</h4>'; }
			if ($daycheck != $longdate && $daycheck != null) { $edate = '<h4>' . $longdate . '</h4>'; }


			// - local time format -
			$time_format = 'F j';
			$stime = date($time_format, $sd);
			$etime = date($time_format, $ed);

			if($stime == $etime) {
				$einfo = $stime;
			} else {
				$einfo = $stime . ' - ' . $etime;;
			}

			/*
			if($stime == $etime) {
				$einfo = 'Event Date: '.$stime;
			} else {
				$einfo = 'Event Dates: '.$stime . ' - ' . $etime;;
			}
			*/

			// - date

			$title = get_the_title();

			// - output -
			if($style == 'archive') {
			?>


				<article <?php post_class(); ?>>

					<div class="row entry-container">

							<div class="col-lg-2 col-md-2 col-sm-2">
								<div class="entry-meta-info event-meta">
								<?php get_template_part('templates/entry-meta-events'); ?>
								</div>
							</div>

							<div class="col-lg-10 col-md-10 col-sm-10">
								<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<hr>
								<div class="entry-summary">
									<?php the_excerpt(); ?>
								</div>
							</div>
				</article>

			<?php
			} else {
			?>
				<li class="bigTargetBox">
                    <span class="date"><?php event_meta('homepage'); ?></span>
                    <a href="<?php the_permalink(); ?>" title="<?php echo $title; ?>" class="bigTarget title-row"><h4><?php echo neat_trim($title, 120); ?> <span class="glyphicon glyphicon-play"></span></h4></a>
                <?php
                $delim = '... <a class="con-read pull-right" href="';
				$delim .= get_the_permalink();
				$delim .= '">View Event</a>';
                echo neat_trim_code(get_the_excerpt(),50,$delim); ?>
				<div class="clearfix"></div>
				</li>

				<?php /*?><li>
					<h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo neat_trim($title, 60); ?></a></h5>
					<p class="date"><?php echo $einfo; ?></p>
				</li><?php */?>
			<?php
			}

			// - fill daycheck with the current day -
			$daycheck = $longdate;

		endforeach;
		// output
		if($style != 'archive') { echo '</ol>'; }

	} else {

		echo '<p>There are no upcoming events at this time.</p>';

	}

	// ===== RETURN: FULL EVENTS SECTION =====

	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

add_shortcode('events', 'events'); // You can now call onto this shortcode with [events limit='20']



// 2) Just Meta Dates and Signup
//***********************************************************************************

function event_meta($style) {
	$custom = get_post_custom(get_the_ID());
	$sd = $custom["events_startdate"][0];
	$ed = $custom["events_enddate"][0];
	$location = $custom["events_location"][0];
	$address = $custom["events_address"][0];
	$signup = $custom["events_signup"][0];
	$directions = $custom["events_directions"][0];

	$startdate = date("F j, Y", $sd);
	$enddate = date("F j, Y", $sd);


	// if date spans multiple dates

	// if time has start and end
	$time_format = 'g:i A';

	$stime = date($time_format, $sd);
	$etime = date($time_format, $ed);
	if($stime == $etime) {
		$einfo = $stime;
	} else {
		$einfo = $stime . ' - ' . $etime;;
	}
	// if default time (noon) then don't show
	if($stime == '12:00 AM' && $etime == '12:00 AM') {
		$einfo = 'NA';
	}


	if(is_archive()) {
		// - determine if it's a new day
		// - and not the "big list" style
		echo '<p>';
		if ($startdate != null) { echo '<span class="date">' . $startdate . '</span> '; }
		if (strlen($location)>0) { echo ' &mdash; <span class="location">' . $location . '</span> '; }
		// if (strlen($signup)>0) { echo do_shortcode('[button link="' . $signup . '"]Event Signup[/button]'); }
		echo '</p>';

	} elseif($style == 'homepage') {
		if($startdate == $enddate) {
			echo $startdate;
		} else {
			echo $startdate.' to '.$startdate;
		}
		if (strlen($location)>0) { echo ' - ' . $location; }
	
	} else {


		echo '<table  class="table">';

		if($startdate == $enddate) {
			echo '<tr><td><p class="date"><span class="">Date:</span></p></td><td><p>'.$startdate.'</p></td></tr>';
		} else {
			echo '<tr><td><p class="date"><span class="">Dates:</span></p></td><td><p>'.$startdate.' to '.$startdate.'</p></td></tr>';
		}
		if(strlen($einfo)>0) {
			echo '<tr><td><p class="time"><span class="">Time:</span></p></td><td><p>'.$einfo.' Central Time</p></td></tr>';
		}

		// if full address is set, show that instead of brief location
		if (strlen($address)>0) {
			echo '<tr><td><p class="location"><span class="">Location:</span></p></td><td><p>' . nl2br($address) . '</p>';
			// if directions url is set, show it
			if (strlen($directions)>0) { echo '<p><a href="' . $directions . '" target="_blank">Directions</a></p>'; }
			echo '</td></tr>';
		} elseif (strlen($location)>0) {
			echo '<tr><td><p class="location"><span class="">Location:</span></p></td><td><p>' . $location . '</p>';
			// if directions url is set, show it
			if (strlen($directions)>0) { echo '<p><a href="' . $directions . '" target="_blank">Directions</a></p>'; }
			echo '</td></tr>';
		}




		echo '</table>';

		if (strlen($signup)>0) { echo '<a href="' . $signup . '" class="btn btn-primary btn-large">Signup For Event</a>'; }
	}
}


// 3) Check for Form and Display it
//***********************************************************************************

function event_form($check = "false") {
	$custom = get_post_custom(get_the_ID());
	$form = $custom["events_form"][0];
	$redirect_to = $custom["events_redirect_to"][0];
	$offer_name = $custom["offer_name"][0];
	$offer_category = $custom["offer_category"][0];

	// if no success page provided, use default
	if (strlen($form)>0) { $redirect_to = 'http://www.bdosolutions.com/ca/success'; }

	// add the event id
	$redirect_to = $redirect_to.'&id='.get_the_ID();

	 // ClickDimensions shortcode
	$form_code = '[clickdimensions form_url="http://analytics.clickdimensions.com/forms/h/aCPhK4pPf9UuyrZC6l5tQ" form_template="includes/form-event.inc.php" form_url='.$form.' redirect_to='.$redirect_to.' offer_name="'.$offer_name.'" offer_category="'.$offer_category.'" width=380 height=450]';


	// are we just checking if there is a form specified or displaying the form?
	if($check == 'true') {
		if (strlen($form)>0) return true;
	} else {
		if (strlen($form)>0) { echo do_shortcode($form_code); }
	}
}


// 4) Link to ical
//***********************************************************************************

function event_ical($id = "false", $return = "false", $copy = "Download Appointment Reminder") {
	// if id hasn't been passed, hopefully were within an event so grab that
	if($id == 'false') {
		$id = get_the_ID();
		$custom = get_post_custom(get_the_ID());
		$post = get_post(get_the_ID());
 	} else {
		$custom = get_post_custom($id);
		$post = get_post($id);
	}

	// pull all the event's info
	$ical_url = 'http://www.bdosolutions.com/ca/assets/ical.php';
	$events_sd = $custom["events_startdate"][0];
	$events_ed = $custom["events_enddate"][0];
	$events_location = $custom["events_location"][0];
	$events_address = $custom["events_address"][0];
	$events_signup = $custom["events_signup"][0];
	$events_form = $custom["events_form"][0];
	$events_redirect_to = $custom["events_redirect_to"][0];
	$events_st = $events_sd;
	$events_et = $events_ed;

	$summary = $post->post_title;
	$uri = get_post_permalink($id);
	$description = ' For additional information call 713-850-0747 or visit '.$uri;
	$filename = $post-post_name;



	// - grab gmt for start -
	$gmts = date('Y-m-d H:i:s', $events_sd);
	$gmts = get_gmt_from_date($gmts); // this function requires Y-m-d H:i:s
	$gmts = strtotime($gmts);

	// - grab gmt for end -
	$gmte = date('Y-m-d H:i:s', $events_ed);
	$gmte = get_gmt_from_date($gmte); // this function requires Y-m-d H:i:s
	$gmte = strtotime($gmte);

	// - Set to UTC ICAL FORMAT -
	$stime = date('Ymd\THis\Z', $gmts);
	$etime = date('Ymd\THis\Z', $gmte);

	// create the url to the ical generator
	// http://www.bdosolutions.com/ca/assets/ical.php?s=Title&ds=x&de=y&a=Houston, TX&u=http://www.test.com&d=description&f=event
	$echo = '<p><a class="btn btn-sample" href="'.$ical_url . '?';
	$echo .= 's='.$summary;
	$echo .= '&ds='.$stime;
	$echo .= '&de='.$etime;
	$echo .= '&a='.$events_address;
	$echo .= '&u='.$uri;
	$echo .= '&d='.$description;
	$echo .= '&f='.$filename;
	$echo .='">Add to Calendar</a></p>';


	// if return flag specified show url
	if($return != 'false') {
		$echo .= '<p><a class="btn" href="'.$uri.'">Return to the event detail page</a></a>';
	}

	// display error if we can't get an id
	if(isset($custom)) {
		return $echo;
	} else {
		return 'Error, event ID required.';
	}

}


//***********************************************************************************
// Event .ICAL format
// Not sure how this functions
//***********************************************************************************
 /*
function tf_events_ical() {

// - start collecting output -
ob_start();

// - file header -
header('Content-type: text/calendar');
header('Content-Disposition: attachment; filename="ical.ics"');

// - content header -
?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//<?php the_title(); ?>//NONSGML Events //EN
X-WR-CALNAME:<?php the_title(); _e(' - Events','themeforce'); ?>
X-ORIGINAL-URL:<?php echo the_permalink(); ?>
X-WR-CALDESC:<?php the_title(); _e(' - Events','themeforce'); ?>
CALSCALE:GREGORIAN
 <?php

// - grab date barrier -
$today6am = strtotime('today 6:00') + ( get_option( 'gmt_offset' ) * 3600 );
$limit = get_option('pubforce_rss_limit');

// - query -
global $wpdb;
$querystr = "
    SELECT *
    FROM $wpdb->posts wposts, $wpdb->postmeta metastart, $wpdb->postmeta metaend
    WHERE (wposts.ID = metastart.post_id AND wposts.ID = metaend.post_id)
    AND (metaend.meta_key = 'tf_events_enddate' AND metaend.meta_value > $today6am )
    AND metastart.meta_key = 'tf_events_enddate'
    AND wposts.post_type = 'tf_events'
    AND wposts.post_status = 'publish'
    ORDER BY metastart.meta_value ASC LIMIT $limit
 ";

$events = $wpdb->get_results($querystr, OBJECT);

// - loop -
if ($events):
global $post;
foreach ($events as $post):
setup_postdata($post);

// - custom variables -
$custom = get_post_custom(get_the_ID());
$sd = $custom["tf_events_startdate"][0];
$ed = $custom["tf_events_enddate"][0];

// - grab gmt for start -
$gmts = date('Y-m-d H:i:s', $sd);
$gmts = get_gmt_from_date($gmts); // this function requires Y-m-d H:i:s
$gmts = strtotime($gmts);

// - grab gmt for end -
$gmte = date('Y-m-d H:i:s', $ed);
$gmte = get_gmt_from_date($gmte); // this function requires Y-m-d H:i:s
$gmte = strtotime($gmte);

// - Set to UTC ICAL FORMAT -
$stime = date('Ymd\THis\Z', $gmts);
$etime = date('Ymd\THis\Z', $gmte);
?>
BEGIN:VEVENT
DTSTART:<?php echo $stime; ?>
DTEND:<?php echo $etime; ?>
SUMMARY:<?php echo the_title(); ?>
DESCRIPTION:<?php the_excerpt_rss('', TRUE, '', 50); ?>
END:VEVENT
<?php
endforeach;
else :
endif;
?>
END:VCALENDAR
<?php
// - full output -
$tfeventsical = ob_get_contents();
ob_end_clean();
echo $tfeventsical;
}

function add_tf_events_ical_feed () {
    // - add it to WP RSS feeds -
    add_feed('tf-events-ical', 'tf_events_ical');
}

add_action('init','add_tf_events_ical_feed');

*/
?>
