<?php 


    // class main_class { 
    //     private $mods = array(); 
    //     public function __construct() { 
    //         global $classes; 
    //         $this->mods = $classes; 
    //     } 
    //     public function __get($var) { 
    //         foreach($this->mods as $mod) if(property_exists($mod, $var)) return $mod -> $var; 
    //     }  
    //     public function __call($method, $args) { 
    //         foreach ($this->mods as $mod) if(method_exists($mod, $method)) return call_user_method_array($method, $mod, $args); 
    //     }
    // }

    // class modMe { 
    //     private $_MODS = array(); 
    //     public function __construct__() { 
    //         global $MODS_ENABLED; 
    //         $this -> $_MODS = $MODS_ENABLED; 
    //     } 
    //     public function __get( $var ) { 
    //         foreach ( $this->_MODS as $mod ) if ( property_exists( $mod, $var ) ) return $mod -> $var; 
    //     } 
    //     public function __call( $method, $args ) { 
    //         foreach ( $this->_MODS as $mod ) if ( method_exists( $mod, $method ) ) return call_user_method_array( $method, $mod, $args ); 
    //     } 
    // } 
    // class mainClass extends modMe { 
    //     function __construct(...){ 
    //         $this -> __construct__(); 
    //     } 
    // }
    // $MODS_ENABLED = array(); 
    // $MODS_ENABLED[] = new mod_mail(); 
    // $myObj = new main_class(...); 
    // $myObj->mail("me@me.me","you@you.you","subject","message/body","Extra:Headers;More:Headers");  -->



    class saludos {
        public $adios = 'Adios';
        public $hola = 'Hola';
    }
    class malaspalabras {
        public $cojone = 'Cojone';
        public $pinga = 'Pinga';
    }

    $classes = array(); 
    $classes['saludos'] = new saludos; 
    $classes['malaspalabras'] = new malaspalabras; 
    // echo '<pre>';
    // print_r($classes);
    // echo '</pre>';
    echo $classes['saludos']->adios;

?>
