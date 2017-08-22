
$(document).ready(function() {
    $(function() {
        $("#dialog").dialog({
            autoOpen: false
        });
        $("#btnAddURL").on("click", function() {
            $("#dialog").dialog("open");
        });
    });
    // Validating Form Fields.....
    $("#submit").click(function(e) {
        var url = $("#txtURL").val();
        var urlReg = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
        if (url === '') {
            alert("Please fill all fields.");
            e.preventDefault();
        } else if (!(url).match(urlReg)) {
            alert("Invalid URL.");
            e.preventDefault();
        } else {
            $("#dialog").dialog("close");
            $.post("addUrl.php", 
            {txtURL: $("#txtURL").val()}, 
            function(data) {
                $("#divLoadingGif").hide();
                alert(data);
            });
            window.location.reload();
        }
    });

    $("#btnModifyDelete").click(function(e) {
        
    });
});