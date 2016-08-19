$('.add-department-modal').on('click',function(){
    var url = $(this).data('url');
    $.get(url, function(res){
        $('#modal').html(res).modal();    
    });
});

$('#modal').on('keydown', '#js-add-department-name', function(event){
    if (event.keyCode==13) {
        var url = $('.add-dwepartment').data('url');
        var data = $('form').serialize();
        $.post(url, data, function(){
            location.reload();
        });
    }
});

$('body').on('click', '.add-department', function(event){
    var url = $(this).data('url');
    var data = $('form').serialize();
    $.post(url, data, function(){
        location.reload();
    });
});

$('#modal').on('keydown', '#js-edit-department-name', function(event){
    if (event.keyCode==13) {
        var url = $('.edit-department').data('url');
        var data = $('form').serialize();
        $.post(url, data, function(){
            location.reload();
        });
    }
});

$('.del-department').on('click', function(){
    var url = $(this).data('url');
    if (confirm('确认删除')) {
    $.post(url, function(){
        location.reload();
    });
    }
});

$('.edit-department-modal').on('click',function(res){
    var url = $(this).data('url');
    $.get(url, function(res){
        $('#modal').html(res).modal();
    });
});

$('body').on('click', '.edit-department', function(res){
    var url = $(this).data('url');
    var data = $('form').serialize();
    $.post(url,data,function(res){
        location.reload();
    });
});
