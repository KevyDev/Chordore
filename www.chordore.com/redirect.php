<?php

    require_once 'php/app.php';
    if(isset($_GET['url'])) {
        $url = $_GET['url'];
        //$app->insertUrl($url);
        header('location: '.$url);
    } else {
        header('location: '.$app->url);
        die();
    }

?>