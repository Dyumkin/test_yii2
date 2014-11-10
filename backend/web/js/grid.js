/**
 * Created by yury on 10.11.14.
 */
$(function(){
    $('body').on('click', '.grid-action', function(e){
        var href = $(this).attr('href');
        var self = this;
        $.get(href, function(){
            var pjax_id = $(self).closest('.pjax-wraper').attr('id');
            $.pjax.reload('#' + pjax_id);
        });
        return false;
    })
})