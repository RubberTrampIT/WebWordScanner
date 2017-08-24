<?php
if (!empty($_POST["urlId"])) {
    $urlId = $_POST["urlId"];
    // echo $urlId.": ".$url;
    deleteURL($urlId);
} else {
    ## Debugging ONLY
    // $urlId = "1";
    // $url = "123456";
    // saveNewURL($urlId,$url);
}

function deleteURL($urlId) {
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'webwordscanner');
    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit();
    }

    $stmt = $mysqli->prepare("DELETE u, r FROM urls u LEFT JOIN results r ON r.urlId = u.id WHERE u.id=?");
    $stmt->bind_param('s', $urlId);
    $stmt->execute();
}
?>