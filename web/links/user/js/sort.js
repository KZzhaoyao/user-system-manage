$(function() {
    var $tb = $("#user-table");
    var des = true;
    var deg = 'down';
    $('#sort-number').on("click", function() {
        if (deg == 'down') {
            $('.change-glyphicon').css('transform','rotate(180deg)');
            deg = 'up';
        } else {
            $('.change-glyphicon').css('transform','rotate(0deg)');
            deg = 'down';
        }
        $tb.sortTable({
            onCol: 1,
            keepRelationships: true,
            sortDesc: des
        });
        des = !des;
    });
});