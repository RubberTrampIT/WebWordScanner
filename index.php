<?php error_reporting( E_ALL ); ?>

<html>
<head>
    <link rel="stylesheet" href="includes/css/bootstrap.min.css"> 
    <script src="includes/js/jquery-3.2.1.min.js"></script>
</head>

<body>
 


<br />
<br />  
<div class="container">
    <div class="row">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-3">
            <form id="searchForm">
                <div class="form-group">
                    <label for="searchWordLabel">Search Word:</label>
                    <input type="text" class="form-control" id="searchWord" placeholder="Enter word to search for...">
                </div>
                <input type="button" class="btn btn-default" id="btnSubmit" value="Search">
            </form> 
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">&nbsp;</div>
        <div class="col-lg-4" id='displayResultsDiv'>

        </div>
    </div>
</div>

 <script>
$(document).ready(function() {
    $("#btnSubmit").click(function(){        
        $.post("searchWord.php", 
        {searchWord: $("#searchWord").val()}, 
        function(data) {
            $("#displayResultsDiv").text(data);
        });
    });
    $('#searchWord').keypress(function (e) {
        if (e.which == 13 || e.which == 10) {
            e.preventDefault();
            $.post("searchWord.php", 
            {searchWord: $("#searchWord").val()}, 
            function(data) {
                $("#displayResultsDiv").text(data);
            });
        }
    });
});

</script>

</body>
</html>