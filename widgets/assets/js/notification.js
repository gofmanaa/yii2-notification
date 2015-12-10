/**
 * Created by bigdrop on 12/9/15.
 */

$(function() {

    $('.notifications-menu').on('click','.not_read',function(e){
        e.stopPropagation();
        $.ajax({
            type:'POST',
            dataType:'json',
            url:$('.notifications-menu').data('url'),
            context:this,
            data:{id:$(this).data('id')},
            success:function(res){
                $(this).removeClass('not_read');
                $(this).closest('li').fadeOut();
            },
            error: function (jqXHR, textStatus) {
                alert( "Internal Error!" );
            }
        });

        return false;

    });


});