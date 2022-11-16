<?php

if(isset($_GET['sc']) && isset($_GET['file'])) {
    $folder = $_GET['sc'];
    $file = $_GET['file'];
    $location = 'imgs-sc'.$folder.'/'.$file;
        if(file_exists($location)) {
            $image = exif_read_data($location);
            $img = imagecreatefromjpeg($location); 
            header("Content-type: image/jpeg");
            imagejpeg($img);    
        } else {
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        }
    } else {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
    }

?>