<?php

    class ComponentRegistry {

        private $components;

        function __construct() {}

        // private validatePath -> when a component is submitted validate it has/or it doesn't a slash (/) at the beginning of the path

        private function trailing_slash( $string ) {
            if ( substr( $string, strlen($string) - 1, 1 ) != '/' && strlen($string) ) {
                return $string.'/';
            }
            return $string;
        }

        public function add($component, $path) {
            $array = array();
            if ( isset($component['id']) ) {
                $array['id'] = $component['id'];
            }
            if ( isset($component['view']) ) {
                $array['view'] = array();
                if ( isset($component['view']['templates']) ) {
                    $array['view']['templates'] = array();
                    for ( $n = 0; $n < count($component['view']['templates']); $n++ ) {
                        array_push( $array['view']['templates'], $this->trailing_slash($path).$component['view']['templates'][$n] );
                    }
                }
                if ( isset($component['view']['styles']) ) {
                    $array['view']['styles'] = array();
                    for ( $n = 0; $n < count($component['view']['styles']); $n++ ) {
                        array_push( $array['view']['styles'], $this->trailing_slash($path).$component['view']['styles'][$n] );
                    }
                }
                if ( isset($component['view']['scripts']) ) {
                    $array['view']['scripts'] = array();
                    for ( $n = 0; $n < count($component['view']['scripts']); $n++ ) {
                        array_push( $array['view']['scripts'], $this->trailing_slash($path).$component['view']['scripts'][$n] );
                    }
                }
            }
            $this->components[$component['id']] = $array;
        }

        public function get( $component_id = null ) {
            if ( !$component_id ) {
                return $this->components;
            }
            if ( !isset($this->components[$component_id]) ) {
                return false;
            }
            return $this->components[$component_id];
        }

        public function init() {
            $this->components = array();
        }
    }
?>
