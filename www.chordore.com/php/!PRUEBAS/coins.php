<?php

    class Coins {
        function add($coins_total, $coins_add) {
            if(is_numeric($coins_total) && is_array($coins_add)) {
                $result = $coins_total;
                foreach($coins_add as $coins_add_e) {
                    if(is_numeric($coins_add_e)) {
                        $result = $result + $coins_add_e;
                    } else {
                        return false;
                    }
                }
                return round($result, 4);
            } else {
                return false;
            }
        }
        function remove($coins_total, $coins_remove) {
            if(is_numeric($coins_total) && is_array($coins_remove)) {
                $result = $coins_total;
                foreach($coins_remove as $coins_remove_e) {
                    if(is_numeric($coins_remove_e)) {
                        $result = $result - $coins_remove_e;
                    } else {
                        return false;
                    }
                }
                if($result < 0) {
                    return false;
                } else {
                    return round($result, 4);
                }
            } else {
                return false;
            }
        }
        function discount($coins_total, $porcent_discount) {
            if(is_numeric($coins_total) && is_numeric($porcent_discount)) {
                $result = $coins_total - (($porcent_discount / 100) * $coins_total);
                if(is_numeric($result)) {
                    if($result < 0) {
                        return false;
                    } else {
                        return round($result, 4);
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    $coins = new Coins;

?>