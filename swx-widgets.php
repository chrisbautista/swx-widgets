<?php
/**
 * @package SWX Widgets
 */
/*
Plugin Name: SWX Widgets & Shortcodes
Plugin URI: http://www.salesworks.com
Description: Custom widgets and Shortcodes
Version: 1.0
Author: Colin Greig
Author URI: http://www.colingreig.com
License: GPLv2 or later
*/

define( 'SWX_FILEPATH', plugin_dir_path(__FILE__) );
// load settings page
require_once (SWX_FILEPATH . '/functions/acf-options.php');


/*-----------------------------------------------------------------------------------*/
/*	Print templates in footer
/*-----------------------------------------------------------------------------------*/
// Bug testing only. Not to be used on a production site!!
/*
add_action('wp_footer', 'roots_wrap_info');

function roots_wrap_info() {
  $format = '<h6>The %s template being used is: %s</h6>';
  $main   = Roots_Wrapping::$main_template;
  global $template;

  printf('<h5>DEBUG MODE:</h5>');
  printf('<p>Comment this out in swx-widgets.php</p>'); 
  printf('<h6>The page template is: ' . get_page_template( get_the_ID() ).'</h6>');
  printf('<h6>The post type is: ' . get_post_type( get_the_ID() ).'</h6>');
  if(is_post_type_archive()) printf('<h6>is_post_type_archive is true</h6>');
  printf($format, 'Main', $main);
  printf($format, 'Base', $template);
}
*/
/*-----------------------------------------------------------------------------------*/
/*  Setup
/*-----------------------------------------------------------------------------------*/

require_once (SWX_FILEPATH . '/setup.php');
require_once (SWX_FILEPATH . '/functions/class-acf-options.php');


/*-----------------------------------------------------------------------------------*/
/*	Load Custom Post Types
/*-----------------------------------------------------------------------------------*/

require_once (SWX_FILEPATH . '/functions/post-type-testimonials.php');
require_once (SWX_FILEPATH . '/functions/post-type-testimonials-staff.php');
//require_once (SWX_FILEPATH . '/functions/post-type-events.php');
require_once (SWX_FILEPATH . '/functions/post-type-news.php');
// require_once (SWX_FILEPATH . '/functions/post-type-squeeze-page.php');
 require_once (SWX_FILEPATH . '/functions/post-type-awards.php');
// require_once (SWX_FILEPATH . '/functions/post-type-jobs.php');
// require_once (SWX_FILEPATH . '/functions/post-type-videos.php');
//require_once (SWX_FILEPATH . '/functions/post-type-customers.php'); // ACF required, includes testimonials
//require_once (SWX_FILEPATH . '/functions/post-type-partners.php'); // ACF required
//require_once (SWX_FILEPATH . '/functions/post-type-posts.php'); // ACF required
//require_once (SWX_FILEPATH . '/functions/post-type-taxonomies.php');




/*-----------------------------------------------------------------------------------*/
/*	Load Custom Functions / Shortcodes
/*-----------------------------------------------------------------------------------*/

require_once (SWX_FILEPATH . '/functions/functions-micro.php');
//require_once (SWX_FILEPATH . '/functions/functions-speak-to-an-expert.php');
//require_once (SWX_FILEPATH . '/functions/functions-ppc.php');
//require_once (SWX_FILEPATH . '/functions/functions-pardot.php');
//require_once (SWX_FILEPATH . '/functions/functions-clickdimensions.php');
require_once (SWX_FILEPATH . '/functions/functions-custom-author-box.php');
//require_once (SWX_FILEPATH . '/functions/functions-salesworks-methodology.php');
//require_once (SWX_FILEPATH . '/functions/functions-social.php');
//require_once (SWX_FILEPATH . '/functions/functions-big-headers.php');
//require_once (SWX_FILEPATH . '/functions/functions-pop-modal-contact-form.php');
//require_once (SWX_FILEPATH . '/functions/functions-insights.php');
//require_once (SWX_FILEPATH . '/functions/functions-callouts-acf.php');
require_once (SWX_FILEPATH . '/functions/functions-dynamic-fields-acf.php');
//require_once (SWX_FILEPATH . '/functions/functions-hubspot-shortcodes.php');


/*-----------------------------------------------------------------------------------*/
/*	Load Custom Widgets
/*-----------------------------------------------------------------------------------*/

//require_once (SWX_FILEPATH . '/functions/widget-aweber.php');
//require_once (SWX_FILEPATH . '/functions/widget-contextual-categories.php');
//require_once (SWX_FILEPATH . '/functions/widget-contextual-links.php');
//require_once (SWX_FILEPATH . '/functions/widget-contextual-authors.php');
//require_once (SWX_FILEPATH . '/functions/widget-download-monitor.php');
//require_once (SWX_FILEPATH . '/functions/widget-contextual-downloads.php');
//require_once (SWX_FILEPATH . '/functions/widget-locations.php');
//require_once (SWX_FILEPATH . '/functions/widget-socialite-plugin.php');
//require_once (SWX_FILEPATH . '/functions/functions-hubspot-ctas-shortcode.php');
?>