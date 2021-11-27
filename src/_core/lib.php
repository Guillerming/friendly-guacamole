<?php

    class Lib {

        public function add_trailing_slash( $string ) {
            if ( substr( $string, strlen($string) - 1, 1 ) != '/' && strlen($string) ) {
                return $string.'/';
            }
            return $string;
        }

        public function remove_trailing_slash( $string ) {
            if ( substr( $string, strlen($string) - 1, 1 ) == '/' && strlen($string) >= 2 ) {
                return substr( $string, 0, strlen($string) - 1 );
            }
            return $string;
        }
    }

?>