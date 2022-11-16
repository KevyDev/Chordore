<?php
    // $total = 1000;
    // $numbers = array();
    // $count = 1;
    // while($count < 101) {
    //     $numbers[$count] = 0;
    //     $count++;
    // }
    // $count = 1;
    // while($count < $total) {
    //     $number = mt_rand(1, 100);
    //     $numbers[$number]++;
    //     $count++;
    // }
    // $porcents = array();
    // $count = 1;
    // foreach($numbers as $number) {
    //     $porcent = ($number / $total) * 100;
    //     $porcents[$count] = '%'.$porcent;
    //     $count++;
    // }
    // echo '<pre>';
    // print_r($porcents);
    // echo '</pre>';
?>

<script>

        const socket = new WebSocket('wss://chordore.com/prueba3.php');
        socket.onopen = e => {
            console.log(e);
        };
        socket.onerror = e => {
            console.log(e);
        };

</script>