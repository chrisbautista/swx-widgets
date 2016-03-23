<?php
// ACF Options page
// http://www.advancedcustomfields.com/resources/options-page/

if( function_exists('acf_add_options_page') ) {
	
//	acf_add_options_page();
	
}

/* 
   Debug preview with custom fields 
   http://support.advancedcustomfields.com/forums/topic/preview-solution/
*/ 

add_filter('_wp_post_revision_fields', 'add_field_debug_preview');
function add_field_debug_preview($fields){
   $fields["debug_preview"] = "debug_preview";
   return $fields;
}

add_action( 'edit_form_after_title', 'add_input_debug_preview' );
function add_input_debug_preview() {
   echo '<input type="hidden" name="debug_preview" value="debug_preview">';
}

?>