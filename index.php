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
        <div class="col-lg-3"><button class="btn btn-default" id="btnURLList">URL List</button></div>
        <div class="col-lg-3">
            <form id="searchForm">
                <div class="form-group">
                    <input type="text" class="form-control" id="searchWord" placeholder="Enter word to search for...">
                </div>
                <input type="button" class="btn btn-default" id="btnSubmit" value="Search">
            </form> 
        </div>
        <div class="col-lg-3">
            <form id="searchBingForm">
                <div class="form-group">
                    <input type="text" class="form-control" id="txtSearchBing" placeholder="Query Bing News Articles">
                </div>
                <input type="button" class="btn btn-default" id="btnSubmitBingSearch" value="Search Bing News">
            </form> 
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-3" id="divLoadingGif">
            <img src="includes/images/loading.gif">
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-1">&nbsp;</div>
        <div class="col-lg-8" id='displayResultsDiv'>
            
        </div>
    </div>
</div>

 <script>
$(document).ready(function() {
    $("#divLoadingGif").hide();

    $("#btnURLList").click(function(e) {
        e.preventDefault();
        window.location.replace("./urlList.php");
    })

    $("#btnSubmit").click(function(e){   
        e.preventDefault();     
        $("#displayResultsDiv").hide();
        $("#divLoadingGif").show();
        $.post("searchWord.php", 
        {searchWord: $("#searchWord").val()}, 
        function(data) {
            $("#divLoadingGif").hide();
            $("#displayResultsDiv").html(data);
        })
        .done(function() {
            $("#displayResultsDiv").show();
        })
        .fail(function() {
            alert("Search Failed.  Please Try Again Later.");
        })
    });
    $('#searchWord').keypress(function (e) {
        if (e.which == 13 || e.which == 10) {
            e.preventDefault();
            $("#displayResultsDiv").hide();
            $("#divLoadingGif").show();
            $.post("searchWord.php", 
            {searchWord: $("#searchWord").val()}, 
            function(data) {
                $("#divLoadingGif").hide();
                $("#displayResultsDiv").html(data);
            })
            .done(function() {
                $("#displayResultsDiv").show();
            })
            .fail(function() {
                alert("Search Failed.  Please Try Again Later.");
            });
        }
    });

    $('#txtSearchBing').keypress(function (e) {
        if (e.which == 13 || e.which == 10) {
            e.preventDefault();
            // $("#displayResultsDiv").hide();
            $("#divLoadingGif").show();
            var searchWord = $("#txtSearchBing").val();
            $.post("queryBing.php", 
            {searchWord: searchWord}, 
            function(data) {
                // $.post("searchWord.php",
                // {searchWord: searchWord},
                // function(data) {
                //     $("#divLoadingGif").hide();
                //     $("#displayResultsDiv").html(data);
                // })
            })
            .done(function() {
                $.post("searchWord.php",
                {searchWord: searchWord},
                function(data) {
                    $("#divLoadingGif").hide();
                    $("#displayResultsDiv").html(data);
                })
                $("#displayResultsDiv").show();
            })
            .fail(function() {
                $("#divLoadingGif").hide();
                alert("Search Failed.  Please Try Again Later.");
            });
            // .always(function() {
            //     getResultsWhenFail(searchWord);
            // });
        }
    });

    $('#btnSubmitBingSearch').click(function (e) {
            e.preventDefault();
            // $("#displayResultsDiv").hide();
            $("#divLoadingGif").show();
            var searchWord = $("#txtSearchBing").val();
            $.post("queryBing.php", 
            {searchWord: searchWord}, 
            function(data) {
                $.post("searchWord.php",
                {searchWord: searchWord},
                function(data) {
                    $("#divLoadingGif").hide();
                    $("#displayResultsDiv").html(data);
                })
            })
            .done(function() {
                
                $("#displayResultsDiv").show();
            })
            .fail(function() {
                alert("Search Failed.  Please Try Again Later.");
            });
    });

});

</script>

</body>
</html>