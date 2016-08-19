$('.change-role-modal').on('click',function(){
    $.get($(this).data('url'),function(res){
        $('#modal').html(res).modal();
    });
})

$('.change-role').on('click', function(){
    $.post($(this).data('url'),$('form').serialize(), function(){
    	location.reload();
    });
})