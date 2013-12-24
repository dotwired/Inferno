<?php

// thanks to Eric: http://www.php.net/manual/de/function.setcookie.php#94390

if(!class_exists('Inferno_Cookie_Handler')) {
    class Inferno_Cookie_Handler {

        private static $cookie_portions = '_piece_';

        public static function clearpieces( $inKey , $inFirst ) { 
            $expire = time()-3600; 
            
            for ( $index = $inFirst ; array_key_exists( $inKey.self::$cookie_portions.$index , $_COOKIE ) ; $index += 1 ) { 
                setcookie( $inKey.self::$cookie_portions.$index , '' , $expire , '/' , '' , 0 ); 
                unset( $_COOKIE[$inKey.self::$cookie_portions.$index] ); 
            } 
        } 

        public static function clearcookie( $inKey ) { 
            self::clearpieces( $inKey , 1 ); 
            setcookie( $inKey , '' , time()-3600 , '/' , '' , 0 ); 
            unset( $_COOKIE[$inKey] ); 
        } 

        public static function storecookie( $inKey , $inValue , $inExpire ) { 
            $decode = serialize( $inValue ); 
            $decode = gzcompress( $decode ); 
            $decode = base64_encode( $decode ); 
            
            $split = str_split( $decode , 4000 );//4k pieces 
            $count = count( $split ); 
            
            for ( $index = 0 ; $index < $count ; $index += 1 ) { 
                $result = setcookie( ( $index > 0 ) ? $inKey.self::$cookie_portions.$index : $inKey , $split[$index] , $inExpire , '/' , '' , 0 ); 
            } 
            
            self::clearpieces( $inKey , $count ); 
        } 

        public static function fetchcookie( $inKey ) { 
            $decode = $_COOKIE[$inKey]; 
            
            for ( $index = 1 ; array_key_exists( $inKey.self::$cookie_portions.$index , $_COOKIE ) ; $index += 1 ) { 
                $decode .= $_COOKIE[$inKey.self::$cookie_portions.$index]; 
            } 

            $decode = base64_decode( $decode ); 
            $decode = gzuncompress( $decode ); 
            
            return unserialize( $decode ); 
        } 
    }
}