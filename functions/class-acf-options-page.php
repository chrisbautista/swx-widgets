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
		$this->page_array = $options;
		
	}


	public function page_options()
	{
		if( function_exists('acf_add_options_page') ) {
			foreach($this->page_array as $k => $v){
				acf_add_options_page($v);
			}

		}
	}



} // END class CLASS_ACF_Options_Page



if(isset($site_options)){
	$ACF_Options = new CLASS_ACF_Options_Page($site_options);

	$ACF_Options->page_options();
}

