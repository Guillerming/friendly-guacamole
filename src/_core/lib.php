<?php

    class Lib {

        public function pretty_print_json( $array ) {
            return str_replace('\/', '/', json_encode( $array, JSON_PRETTY_PRINT ) );
        }

        public function load_json_file( $path ) {
            return json_decode( file_get_contents( $path ), true );
        }

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