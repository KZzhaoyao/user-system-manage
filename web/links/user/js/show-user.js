$('#user-table').on('click', '.show-inuser', function(){
    var url = $(this).data('url');
    $.get(url,function(res){
        $('#modal').html(res).modal();
    });
});

$('#modal').on('click','.show-basic-info',function(){
    var url = $(this).data('url');
    $.get(url,function(res){
        $('#modal').html(res).modal();
    });
});

$('#modal').on('click','.show-family-info',function(){
    var url = $(this).data('url');
    $.get(url,function(res){
        $('#modal').html(res).modal();
    });
});

$('#modal').on('click','.show-learn-info',function(){
    var url = $(this).data('url');
    $.get(url,function(res){
        $('#modal').html(res).modal();
    });
});

$('#modal').on('click','.show-work-info',function(){
    var url = $(this).data('url');
    $.get(url,function(res){
        $('#modal').html(res).modal();
    });
});

$('#modal').on('click','.show-other-info',function(){
    var url = $(this).data('url');
    $.get(url,function(res){
        $('#modal').html(res).modal();
    });
});

$('#user-table').on('click', '.js-certificate-btn', function(){
    var url = $(this).data('url');
    $.get(url, function(html){
        $('#modal').html(html).modal();
    });
});

$('#modal').on('click', '.js-certificate-btn', function(){
    var url = $(this).data('url');
    $.get(url, function(html){
        $('#modal').html(html).modal();
    });
});

