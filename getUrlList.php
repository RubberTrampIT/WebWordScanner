<?php

$array = getURLS();

if (count($array) > 0) {
    $string = "<table class='table table-striped table-hover' id='urlTable'>";
    $string .= "<th>URL</th>";
}
foreach ($array as $urlFull) {
    $components = explode(" ", $urlFull);

    $urlId = $components[0];
    $url = $components[1];
    $string .= "<tr><td><input type='button' id=$urlId class='btnURL btn btn-default' style='width: 100%; text-align: left' data-id='#dialogModify' value=".$url."></td></tr>";
}

$string .= "</table>";
echo $string;

function getURLS() {
    $array = array();
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'webwordscanner');

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit();
    }

    if ($sql = "SELECT id, url  FROM urls ORDER BY url DESC") {
        if(!$result = $mysqli->query($sql)){
            die('There was an error running the query [' . $mysqli->error . ']');
        }

        while($row = $result->fetch_assoc()){
            $id = $row['id'];
            $url = $row['url'];
            $string = $id . " " . $url;
            array_push($array, $string);
        }
    
    }
    if (count($array) > 0) {
        return $array;
    }
}

?>