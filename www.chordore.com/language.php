<?php
    
    require_once 'php/app.php';

    if(isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        if(in_array($lang, $app->language['_LIST'])) {
            $_SESSION['lang'] = $lang;
        }
        if(isset($_GET['redirect'])) {
            $redirect = $_GET['redirect'];
        } else {
            $redirect = '';
        }
        header('location: '.$app->url.$redirect);
    } else {
        header('location: '.$app->url.$redirect);
    }

?>