<?php
if (isset($_POST["txtURL"])) {
    $url = $_POST["txtURL"];
    $urlId = $_POST["urlId"];
    // echo $urlId.": ".$url;
    saveNewURL($urlId,$url);
} else {
    ## Debugging ONLY
    // $urlId = "1";
    // $url = "123456";
    // saveNewURL($urlId,$url);
}

function saveNewURL($urlId,$url) {
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'webwordscanner');
    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit();
    }

    $stmt = $mysqli->prepare("UPDATE urls SET url=? WHERE id=?");
    $stmt->bind_param('ss', $url, $urlId);
    $stmt->execute();
}
?>