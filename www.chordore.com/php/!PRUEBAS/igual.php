<?php

    $p1 = 'hola';
    $p2 = 'hola';

    if($p1 == $p2) {
        echo 1;
    } else {
        echo 2;
    }
    
    if(strcmp($p1, $p2) == 0) {
        echo 3;
    } else {
        echo 4;
    }

?>