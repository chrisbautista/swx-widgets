<?
/**
 * DEFINE APPLICATION SPECIFIC SETUPS HERE
 * 
 * 
 */

/**
 * Define site options page field group
 * 
 * (array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title' 	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability' 	=> 'edit_posts',
		'redirect' 	=> false
	)
 * 
 **/
$site_options = array();
$site_options[] = 'Site Options';

$enabled_post_types = array('post','page');
$enabled_post_types[] = 'awards';
$enabled_post_types[] = 'testimonial';
$enabled_post_types[] = 'news';
$enabled_post_types[] = 'training_course';
$enabled_post_types[] = 'training_event';
$enabled_post_types[] = 'report';
$enabled_post_types[] = 'location';
$enabled_post_types[] = 'dlm_download';

$enabled_taxonomies = array();
$enabled_taxonomies['regions'] = array('post_types' => array('post', 'page','training_course','location',));
$enabled_taxonomies['roles'] = array('post_types' => array('post', 'page','report'));
$enabled_taxonomies['platforms'] = array('post_types' => array('post', 'page','report'));
$enabled_taxonomies['products'] = array('post_types' => array('post', 'page','report'));




/*************************

helper functions

*************************/
function is_post_type_defined($post_type){
	global $enabled_post_types;
	
	return in_array($post_type, $enabled_post_types);
}

function is_taxonomy_defined($tax){
	global $enabled_taxonomies;
	
	return isset($enabled_taxonomies[$tax]);
}
