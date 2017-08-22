<?php error_reporting( E_ALL ); ?>

<html>
<head>
    <link rel="stylesheet" href="includes/css/bootstrap.min.css"> 
    <script src="includes/js/jquery-3.2.1.min.js"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="includes/js/dialog.js"></script>
    <link href="includes/css/dialog.css" rel="stylesheet">
</head>

<body>

<div class="main" style="display: none;">
    <div id="dialog" title="Add URL">
        <form action="" method="post" id="addURLForm">
            <label>URL:</label>
            <input id="txtURL" name="txtURL" type="text">
            <input id="submit" type="submit" value="Submit">
        </form>
    </div>
</div> 


<br />
<br />  
<div class="container">
    <div class="row">
        <div class="col-lg-3"><button class="btn btn-default" id="btnWordSearch">Word Search</button></div>
        <div class="col-lg-4"><button class="btn btn-default" id="btnAddURL">Add URL</button>&nbsp;&nbsp;
        <button class="btn btn-default" id="btnModifyDelete">Modify/Delete URL</button></div>
    </div>
    <div class="row">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-3" id="divLoadingGif">
            <img src="includes/images/loading.gif">
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-2">&nbsp;</div>
        <div class="col-lg-6" id='displayResultsDiv'>

        </div>
    </div>
</div>

 <script>
$(document).ready(function() {
    $("#divLoadingGif").hide();
    

    $("#btnWordSearch").click(function(e) {
        e.preventDefault();
        window.location.replace("./index.php");
    });

    $("#divLoadingGif").show();
    $.post("getUrlList.php", 
    function(data) {
        $("#divLoadingGif").hide();
        $("#displayResultsDiv").html(data);
    });

});

</script>

</body>
</html>