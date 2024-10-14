jQuery(document).ready(function(){
    jQuery('.editinline').live('click', function(){
        var tag_id = jQuery(this).parents('tr').attr('id');     
        var start_date = jQuery('.start-date', '#'+tag_id).text();
        var end_date = jQuery('.end-date', '#'+tag_id).text();
        jQuery(':input[name="start-date"]', '.inline-edit-row').val(start_date);
        jQuery(':input[name="end-date"]', '.inline-edit-row').val(end_date);
        return false;
    });
});