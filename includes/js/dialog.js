
$(document).ready(function() {
    $(function() {
        $(".dialog").dialog({
            autoOpen: false
        });

        $("#btnAddURL").click(function() {
            var id = $(this).data('id');
            $(id).dialog("open");
        });
        
        $('body').on('click', '.btnURL', function(e) {
            var btn = $(this);
            var url = btn.val();
            var btnId = btn.attr('id');
            var id = $(this).data('id');
            $("#hiddenURLId").val(btnId);
            $("#txtURLModify").val(url);
            $(id).dialog("open");
        });

        $("#saveURL").click(function(e) {
            var url = $("#txtURLModify").val();
            var urlReg = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
            if (url === '') {
                alert("Please fill all fields.");
                e.preventDefault();
            } else if (!(url).match(urlReg)) {
                alert("Invalid URL.");
                e.preventDefault();
            } else {
                e.preventDefault();
                $.post("modifyUrl.php", 
                {txtURL: $("#txtURLModify").val(),
                urlId: $("#hiddenURLId").val()}, 
                function(data) {
                    $("#divLoadingGif").hide();
                })
                .done(function() {
                    alert("URL Updated Successfully");
                    window.location.reload();
                })
                .fail(function(){
                    alert("Error saving URL.  Please Try Again Later.");
                });
            }
        });

        $("#deleteURL").click(function(e) {
            e.preventDefault();
            $.post("deleteUrl.php", 
            {urlId: $("#hiddenURLId").val()}, 
            function(data) {
                $("#divLoadingGif").hide();
            })
            .done(function() {
                alert("URL Deleted Successfully");
                window.location.reload();
            })
            .fail(function(){
                alert("Error deleting URL.  Please Try Again Later.");
            });
        });
    });

    $("#submitAddURL").click(function(e) {
        var url = $("#txtURL").val();
        var urlReg = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
        if (url === '') {
            alert("Please fill all fields.");
            e.preventDefault();
        } else if (!(url).match(urlReg)) {
            alert("Invalid URL.");
            e.preventDefault();
        } else {
            $("#dialogAddURL").dialog("close");
            $.post("addUrl.php", 
            {txtURL: $("#txtURL").val()}, 
            function(data) {
                $("#divLoadingGif").hide();
                alert(data);
            })
            .fail(function(){
                alert("Error adding URL.  Please Try Again Later.");
            });
            window.location.reload();
        }
    });
});

    // Validating Form Fields.....

    

 

    // $("#btnURL").click(function(e) {
    //     var url = $("#txtURL").val();
    //     var urlReg = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
    //     if (url === '') {
    //         alert("Please fill all fields.");
    //         e.preventDefault();
    //     } else if (!(url).match(urlReg)) {
    //         alert("Invalid URL.");
    //         e.preventDefault();
    //     } else {
    //         $("#dialogModify").dialog("close");
    //         $.post("addUrl.php", 
    //         {txtURL: $("#txtURL").val()}, 
    //         function(data) {
    //             $("#divLoadingGif").hide();
    //             alert(data);
    //         });
    //         window.location.reload();
    //     }
    // });
// });