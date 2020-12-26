<?php

    $allAnime = array();
    $popularAnime = array();
    echo $_GET["url"];

    include 'function/utils.php';
    if( isset($_GET['text']) ) {
        global $allAnime;
        // Call api;
        $url = setUrlApi($_GET,'anime');
        // Get data with GET METHOD
        $data = httpRequest('GET',$url,null);
        $data = json_decode($data)->data;
        $allAnime = setAnime($data);
    }
    $popularAnime = getPopularAnime();
?>



<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>

</body>
</html>