<?php

$fp = fopen($_FILES['file']['tmp_name'], 'rb');
while ( ($line = fgets($fp)) !== false) {
    // if ($line) {
        if (preg_match('/,/',$line)) {
            $splitLine = preg_split('/,/',$line);

            foreach ($splitLine as $url) {
                if (preg_match('/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/',$url,$match)) {
                    // Check if bing redirect URL is in URL
                    if (preg_match_all('/(https:\/\/http:\/\/|www\.)bing\.com(.*)?[r]=(.*)/',$url,$match)) {
                        $url = $match[3][0];
                        $url = rawurldecode($url);
                        addURL($url);
                    } else {
                        $url = rawurldecode($url);
                        addURL($url);
                    }
                }
            }
        } else {
            $url = $splitLine;
            if (preg_match('/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/',$url)) {
                // Check if bing redirect URL is in URL
                if (preg_match_all('/(https:\/\/http:\/\/|www\.)bing\.com(.*)?[r]=(.*)/',$url,$match)) {
                    $url = $match[3][0];
                    $url = rawurldecode($url);
                    addURL($url);
                } else {
                    $url = rawurldecode($url);
                    addURL($url);
                }
            }
        }
    // }
}

header("Location: ./urlList.php");
die();

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
}

?>