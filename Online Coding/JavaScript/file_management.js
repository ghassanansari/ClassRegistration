var url = 'file_management.php';
$("#delete").click(function() {
    $.ajax({
        url : url,
        type: 'post',
        data : {
            filename : $("input[name=files]:checked").val(),
            action : 'delete'
        }
    });
});
$("#load").click( function() {
    $.ajax({
        url : url,
        type: 'post',
        data : {
            filename : $("input[name=files]:checked").val(),
            action : 'load'
        },
        success : function(html) {
           editor.setValue(html);
        }
    });
});