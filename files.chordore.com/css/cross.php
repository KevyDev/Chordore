<?php

    if(isset($_GET['font'])) {
        $font = $_GET['font'];
        if(file_exists('fonts/'.$font)) {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/font');
            echo file_get_contents('fonts/'.$font);
        }
    }

?>