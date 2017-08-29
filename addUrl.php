<?php

if (isset($_POST["txtURL"])) {
    $url = $_POST["txtURL"];
}

addURL($url);

function addURL ($url) {
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'webwordscanner');
    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit();
    }

    $url = strtolower($url);

    $stmt = $mysqli->prepare("INSERT IGNORE INTO urls (`url`) VALUES (?)");
    $stmt->bind_param('s', $url);
    $stmt->execute();

    echo "URL Added Successfully.";
}

?>