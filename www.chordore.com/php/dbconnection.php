<?php
    
    class DBConnection {
        public function DBConnect($hostname, $db_name, $user, $password, $charset) {
            try {
                $connection = new PDO('mysql:dbname='.$db_name.';host='.$hostname.';charset='.$charset, $user, $password);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $connection;
            } catch(PDOException $error) {
                echo 'ERROR: '.$error->getMessage();
            }
        }
    }

?>
