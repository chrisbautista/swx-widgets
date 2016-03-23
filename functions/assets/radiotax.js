/*

jQuery(document).ready(function($) {
    var taxonomy = 'dlm_download_buying_phase';
    $('#' + taxonomy + 'checklist li :radio, #' + taxonomy + 'checklist-pop :radio').live( 'click', function(){
        var t = $(this), c = t.is(':checked'), id = t.val();
        $('#' + taxonomy + 'checklist li :radio, #' + taxonomy + 'checklist-pop :radio').prop('checked',false);
        $('#in-' + taxonomy + '-' + id + ', #in-popular-' + taxonomy + '-' + id).prop( 'checked', c );
    });
});

 */


jQuery(document).ready(function($) {
    var taxonomy = 'dlm_download_buying_phase';
    $('#' + taxonomy + 'checklist li :radio, #' + taxonomy + 'checklist-pop :radio').live( 'click', function(){
        var t = $(this), c = t.is(':checked'), id = t.val();
        $('#' + taxonomy + 'checklist li :radio, #' + taxonomy + 'checklist-pop :radio').prop('checked',false);
        $('#in-' + taxonomy + '-' + id + ', #in-popular-' + taxonomy + '-' + id).prop( 'checked', c );
    });
});