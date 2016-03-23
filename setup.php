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
$options = array();

$options[] = array(
		'page_title' 	=> 'Site Options',
		'menu_title' 	=> 'Site Options',
		'capability' 	=> 'edit_posts',
	);


define('SITE_OPTIONS', $options);