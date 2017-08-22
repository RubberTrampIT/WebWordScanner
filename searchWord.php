
<?php

## Debugging ONLY
error_reporting( E_ALL );
// ini_set("display_error", "OFF");
// $searchWord = "bitcoin";


require("includes/php/simple_html_dom.php");

if (!empty($_POST["searchWord"])) {
    $searchWord = $_POST["searchWord"];
    
    // $url = "https://www.coindesk.com/bitcoin-trading-sideways-bitcoin-cash-drops-800/";
    $urls = getURLS();
    //$urls = array("https://www.coindesk.com/bitcoin-trading-sideways-bitcoin-cash-drops-800/", "https://cointelegraph.com/news/btccom-launches-recovery-tool-to-get-your-trapped-bitcoin-cash", "https://www.cryptocoinsnews.com/gatecoin-bitcoin-to-reach-5000-this-year/");

    foreach ($urls as $urlWithId) {
        $components = explode(" ", $urlWithId);

        $urlId = $components[0];
        $url = $components[1];
        searchPage($searchWord, $urlId, $url);
    }
    displayResults($searchWord);
    
} else {
}

function searchPage($searchWord, $urlId, $url) {
    $ch = curl_init();
    $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
    $timeout = 10;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSLVERSION,CURL_SSLVERSION_DEFAULT);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    if ($html = curl_exec($ch)) {
        $dom = new DOMDocument();
    // @$dom->loadHTML($url);

        if (!curl_errno($ch)) {
            try {
                $text = file_get_html($url)->plaintext;
            } catch (Exception $e) {
                curl_close($ch);
                return false;
            }

            if ($text) {
                if (preg_match_all('/\s'.$searchWord.'\s/', $text, $matches)) {
                    $numMatches = count($matches[0]);
                    updateResultsDB($urlId,$searchWord,'True',$numMatches);
                } else {
                    $numMatches = 0;
                    updateResultsDB($urlId,$searchWord,'False',$numMatches);
                }
            } else {
                $numMatches = NULL;
                updateResultsDB($urlId,$searchWord,'Failed',$numMatches);
            }
        } else {
            updateResultsDB($urlId,$searchWord,'Failed',$numMatches);
        }
        curl_close($ch);
    } else {
        echo "Error";
    }
}

function getURLS() {
    $array = array();
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'webwordscanner');

    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit();
    }

    if ($sql = "SELECT id, url  FROM urls") {
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

function updateResultsDB ($urlId,$searchWord,$matchFound,$numMatches) {
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'webwordscanner');
    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit();
    }

    $stmt = $mysqli->prepare("INSERT INTO results (`urlId`,`wordTested`,`wordFound`,`wordCount`) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE wordTested=?, wordFound=?, wordCount=?");
    $stmt->bind_param('sssssss', $urlId, $searchWord, $matchFound, $numMatches, $searchWord, $matchFound, $numMatches);
    $stmt->execute();

}

function displayResults ($searchWord) {
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'webwordscanner');
    if ($mysqli->connect_errno) {
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit();
    }

    $stmt = $mysqli->prepare("SELECT r.urlId, u.url, r.wordTested, r.wordFound, r.wordCount FROM results r LEFT JOIN urls u ON u.id = r.urlId WHERE wordTested = ? ORDER BY wordCount DESC");
    $stmt->bind_param("s", $searchWord);
    $stmt->execute();
    $result = $stmt->get_result();
    $string= "";
    $string .= "<table class='table table-striped table-hover'>";
    $string .= "<th>URL</th><th>Word Tested</th><th>Word Found</th><th>Word Count</th>";
    while($row = $result->fetch_assoc()){
            $url= $row['url'];
            $wordTested = $row['wordTested'];
            $wordFound = $row['wordFound'];
            $wordCount = $row['wordCount'];
            $string .= "<tr><td>".$url."</td><td>".$wordTested."</td><td>".$wordFound."</td><td>".$wordCount."</td></tr>";
    }
    $string .= "</table>";
    echo $string;
}


?>