<?php
    if (!empty($_POST["searchWord"])) {
        $query = $_POST["searchWord"];
    } else {
        $query = "bitcoin";
    }
    // Bing Endpoints
    $newsURL = "https://api.cognitive.microsoft.com/bing/v5.0/news/search";
    $knowledgeURL = "https://api.cognitive.microsoft.com/bing/v5.0/knowledge/search";
    $videosURL = "https://api.cognitive.microsoft.com/bing/v5.0/videos/search";

    // $query = "Bitcoin";
    $count = 15;
    $sURL = $newsURL."?q=".$query."&count=".$count."&mkt=en-US";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $sURL); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: multipart/form-data',
        'Ocp-Apim-Subscription-Key: 0aa4ba06e81545688052db6a517a3a1e'
    ));
    $contents = curl_exec($ch);
    $myContents = json_decode($contents);
    if(count($myContents->value) > 0) {
        foreach ($myContents->value as $content) {
            // echo $content->url . "<br>";
            $url = $content->url;

            if (preg_match('/,/',$url)) {
                $splitLine = preg_split('/,/',$url);
                foreach ($splitLine as $url) {
                    if (preg_match('/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/',$url)) {
                        if (preg_match_all('/(https:\/\/http:\/\/|www\.)bing\.com(.*)?[r]=(.*)/',$url,$match)) {
                            $url = $match[3][0];
                            $url = rawurldecode($url);
                            if (preg_match('/\w{1}/',$url)) {
                                addURL($url,$query);
                            }
                        } else {
                            $url = rawurldecode($url);
                            if (preg_match('/\w{1}/',$url)) {
                                addURL($url,$query);
                            }
                        }
                    }
                }
                
            } else {
                if (preg_match('/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/',$url)) {
                    if (preg_match_all('/(https:\/\/http:\/\/|www\.)bing\.com(.*)?[r]=(.*)/',$splitLine,$match)) {
                        $url = $match[3][0];
                        $url = rawurldecode($url);
                        if (preg_match('/\w{1}/',$url)) {
                            addURL($url,$query);
                        }
                    } else {
                        $url = rawurldecode($url);
                        if (preg_match('/\w{1}/',$url)) {
                                addURL($url,$query);
                            }
                    }
                }
            }
        }
    }

function addURL ($url,$query) {
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'webwordscanner');
    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit();
    }

    $url = strtolower($url);
    $query = strtolower($query);

    $stmt = $mysqli->prepare("INSERT IGNORE INTO urls (`url`,`searchTerm`) VALUES (?,?)");
    $stmt->bind_param('ss', $url,$query);
    $stmt->execute();
}
?>