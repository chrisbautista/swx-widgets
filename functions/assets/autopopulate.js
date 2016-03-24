jQuery(document).ready(function($) {
 
    // Add default 'Select one'
    $( '#acf-field-country' ).prepend( $('<option></option>').val('0').html('Select Country').attr({ selected: 'selected', disabled: 'disabled'}) );
 
    /**
     * Get country option on select menu change
     *
     */
    $( '#acf-field-country' ).change(function () {
 
        var selected_country = ''; // Selected value
 
        // Get selected value
        $( '#acf-field-country option:selected' ).each(function() {
            selected_country += $( this ).text();
        });
 
    }).change();
});

jQuery(document).ready(function($) {
 
    // Add default 'Select one'
    $( '#acf-field-country' ).prepend( $('<option></option>').val('0').html('Select Country').attr({ selected: 'selected', disabled: 'disabled'}) );
 
    /**
     * Get country options
     *
     */
    $( '#acf-field-country' ).change(function () {
 
        var selected_country = ''; // Selected value
 
        // Get selected value
        $( '#acf-field-country option:selected' ).each(function() {
            selected_country += $( this ).text();
        });
 
        $( '#acf-field-area' ).attr( 'disabled', 'disabled' );
 
        // If default is not selected get areas for selected country
        if( selected_country != 'Select Country' ) {
            // Send AJAX request
            data = {
                action: 'pa_add_areas',
                pa_nonce: pa_vars.pa_nonce,
                country: selected_country,
            };
 
            // Get response and populate area select field
            $.post( ajaxurl, data, function(response) {
 
                if( response ){
                    // Disable 'Select Area' field until country is selected
                    $( '#acf-field-area' ).html( $('<option></option>').val('0').html('Select Area').attr({ selected: 'selected', disabled: 'disabled'}) );
 
                    // Add areas to select field options
                    $.each(response, function(val, text) {
                        $( '#acf-field-area' ).append( $('<option></option>').val(text).html(text) );
                    });
 
                    // Enable 'Select Area' field
                    $( '#acf-field-area' ).removeAttr( 'disabled' );
                };
            });
        }
    }).change();
});