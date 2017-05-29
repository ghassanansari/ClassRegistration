var url = 'file_management.php';
$("#save").click( function() {
    $.ajax({
        url : url,
        type: 'post',
        data : {
			filename : docname,
            action : 'save',
            content : encodeURIComponent(editor.getValue())
        }
    });
});