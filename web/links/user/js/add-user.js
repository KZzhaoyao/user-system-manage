var familyId = 2;
var learnId = 2;
var workId = 2;



$('.family').append($('.family-modal').html());
$('.family').find('#delete-family-info').removeClass('hidden');
$('.learn').append($('.learn-modal').html());
$('.learn').find('#delete-learn-info').removeClass('hidden');
$('.work').append($('.work-modal').html());
$('.work').find('#delete-work-info').removeClass('hidden');

$('#add-user-form').on('click', '.add-family-info', function(){
    $('.family-modal .member').attr('name', 'family['+familyId+'][member]');
    $('.family-modal .familyName').attr('name', 'family['+familyId+'][trueName]');
    $('.family-modal .age').attr('name', 'family['+familyId+'][age]');
    $('.family-modal .job').attr('name', 'family['+familyId+'][job]');
    $('.family-modal .familyphone').attr('name', 'family['+familyId+'][phone]');
    $('.family').append($('.family-modal').html());
    familyId++;
});

$('body').on('click', '.delete-family-info', function(){
    $(this).parent().parent().parent().remove();
})

$('#add-user-form').on('click', '.add-learn-info', function(){
    $('.learn-modal .learnStartTime').attr('name', 'education['+learnId+'][startTime]');
    $('.learn-modal .learnEndTime').attr('name', 'education['+learnId+'][endTime]');
    $('.learn-modal .learnSchoolName').attr('name', 'education['+learnId+'][schoolName]');
    $('.learn-modal .learnProfession').attr('name', 'education['+learnId+'][profession]');
    $('.learn-modal .learnPosition').attr('name', 'education['+learnId+'][position]');
    $('.learn').append($('.learn-modal').html());
    learnId++;
    $('#add-user-form').find('.time').datetimepicker({
       viewMode: 'years',
       format: 'YYYY-MM-DD'
    });
})

$('body').on('click', '.delete-learn-info', function(){
    $(this).parent().parent().parent().remove();
})

$('#add-user-form').on('click', '.add-work-info', function(){
    $('.work-modal .workStartTime').attr('name', 'work['+workId+'][startTime]');
    $('.work-modal .workEndTime').attr('name', 'work['+workId+'][endTime]');
    $('.work-modal .workUnit').attr('name', 'work['+workId+'][company]');
    $('.work-modal .workPosition').attr('name', 'work['+workId+'][position]');
    $('.work-modal .leaveReason').attr('name', 'work['+workId+'][leaveReason]');
    $('.work').append($('.work-modal').html());
    workId++;
    $('#add-user-form').find('.time').datetimepicker({
       viewMode: 'years',
       format: 'YYYY-MM-DD'
    });
})

$('body').on('click', '.delete-work-info', function(){
    $(this).parent().parent().parent().remove();
});

$("#add-user-form").validate({
    rules: {
        'basic[number]': {
            required: true,
            number: true,
            checkNumber: true,
            remote: {
                url: "/admin/user/number/check",     //后台处理程序
                type: "get",               //数据发送方式
                dataType: "json",
                data: {                     //要传递的数据
                    number: function() {
                        return $("#number").val();
                    }
                }
            }
        },
        'basic[trueName]': "required",
        'basic[department]': {
            required: true
        },
        'basic[rank]': {
            required: true
        },
        'basic[phone]': {
            required:true,
            mobile:true
        },
        'basic[email]': {
            required: true,
            email:true
        },
        'basic[professionTitle]': {
            required: true
        },
        'basic[joinTime]': {
            required: true
            }
    },
    messages: {
        'basic[number]': {
            required: "请输入员工工号",
            remote: "该员工工号已存在"
        },
        'basic[trueName]': "请输入姓名",
        'basic[department]': {
            required: "请输入所属部门"
        },
        'basic[rank]': {
            required: "请输入职级"
        },
        'basic[phone]': {
            required: "请输入手机号码"
        },
        'basic[email]': {
            required: "请输入邮箱"
        },
        'basic[professionTitle]': {
            required: "职称不能为空"
        },
        'basic[joinTime]': {
            required: "入职时间不能为空"
        }
    }
});
jQuery.validator.addMethod("mobile", function(value, element) {    
    var length = value.length;    
    return this.optional(element) || (length == 11 && /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value));    
}, "请正确填写您的手机号码");

jQuery.validator.addMethod("checkNumber", function(value, element) { 
    return this.optional(element) || (/^\d{4}$/.test(value));    
}, "请输入四位工号数");
