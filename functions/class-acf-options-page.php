<?php
/**
 * CLASS_ACF_OPtions_Page
 *
 * @package ACF
 * @author 
 **/
class CLASS_ACF_Options_Page
{

	/*
	 * @var array
	 */

	private $page_array;

	function __construct($options = null)
	{
		$this->page_array = $options['field_groups']
		
	}


	public function page_options()
	{
		if( function_exists('acf_add_options_page') ) {
			foreach($this->getPageArray() as $k=>$v){
				acf_add_options_page($v);
			}

		}
	}



} // END class CLASS_ACF_Options_Page

/**
 * 
 * (array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title' 	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability' 	=> 'edit_posts',
		'redirect' 	=> false
	)
 * 
 */
if(defined(SITE_OPTIONS)){
	$ACF_Options = new CLASS_ACF_Options_Page($options);
}


