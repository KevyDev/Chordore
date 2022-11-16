<?php

    $views = 1;
    $money = 1;
    $earnings = earnings($views, $money);
    // ($views / $likes) / ($views / $comments)
    function earnings($views, $money) {
        $result = ($views / 1000) * $money;
        return $result;
    }

    $earnings_user = ($earnings / 100) * 60;
    $earnings_app = ($earnings / 100) * 40;

    echo '$'.$earnings_user;
    echo '<br>';
    echo '$'.$earnings_app;

?>