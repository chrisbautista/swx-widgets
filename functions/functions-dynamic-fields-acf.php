<?php
/* ***************************************************************************** */
/* populate custom fields with values from ACF options panel 
/* http://www.advancedcustomfields.com/resources/dynamically-populate-a-select-fields-choices/
/* ***************************************************************************** */

// Button CSS Classes 
function acf_load_button_css_field_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();        
    // get the textarea value from options page without any formatting
    $choices = get_field('button_css_classes', 'option', false);
    // explode the value so that each line is a new array piece
    $choices = explode("\n", $choices);
    // remove any unwanted white space
    $choices = array_map('trim', $choices);

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        foreach( $choices as $choice ) {
            $field['choices'][ $choice ] = $choice;
        }
    }

    // return the field
    return $field;
}
add_filter('acf/load_field/name=css_predefined_style', 'acf_load_button_css_field_choices');

// CSS Background Predefined Styles
function acf_load_background_css_field_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();        
    // get the textarea value from options page without any formatting
    $choices = get_field('blocks_background_css_classes', 'option', false);
    // explode the value so that each line is a new array piece
    $choices = explode("\n", $choices);
    // remove any unwanted white space
    $choices = array_map('trim', $choices);

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        foreach( $choices as $choice ) {
            $field['choices'][ $choice ] = $choice;
        }
    }

    // return the field
    return $field;
}
add_filter('acf/load_field/name=css_background', 'acf_load_background_css_field_choices');

// load product list from options page to allow for a select list of products
function acf_load_product_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();


    // if has rows
    if( have_rows('products', 'option') ) {
        
        // while has rows
        while( have_rows('products', 'option') ) {
            
            // instantiate row
            the_row();
            
            
            // vars
            $value = get_sub_field('product_title');
            // $label = get_sub_field('product_title');

            
            // append to choices
            $field['choices'][ $value ] = $value;
            
        }
        
    }


    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=product_selection', 'acf_load_product_choices');



// load hubspot catas
function acf_load_ctas( $field ) {
    
    // reset choices
    $field['choices'] = array();


    // if has rows
    if( have_rows('ctas', 'option') ) {
        
        // while has rows
        while( have_rows('ctas', 'option') ) {
            
            // instantiate row
            the_row();
            
            
            // vars
            $value = get_sub_field('title');
            // $label = get_sub_field('product_title');

            
            // append to choices
            $field['choices'][ $value ] = $value;
            
        }
        
    }


    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=select_hubspot_cta', 'acf_load_ctas');


?>