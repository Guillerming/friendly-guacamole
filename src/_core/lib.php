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

        public function create_wrapper_tagname( $id, $addon = null ) {
            global $friendlyGuacamole;
            $tagname = $friendlyGuacamole->SETTINGS['wrapper']['prefix'].$id;
            $tagname = str_replace('_', '-', $tagname);
            if ( $addon ) {
                $tagname .= '-'.$addon;
            }
            return strtolower($tagname);
        }

        public function create_wrapper_attr( $type ) {
            global $friendlyGuacamole;
            if ( $type == 'layout' )         { $type = 'lay'; }
            else if ( $type == 'page' )      { $type = 'pag'; }
            else if ( $type == 'component' ) { $type = 'com'; }
            $component_wrapper  = $friendlyGuacamole->SETTINGS['wrapper']['prefix'];
            $component_wrapper .= $type.'-';
            $component_wrapper .= substr(md5(rand(0,9).(new DateTime())->getTimestamp()),0,3);
            return $component_wrapper;
        }
    }

?>