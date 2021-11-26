<?php

    class PagesModule {

        private $pages_registry;

        private $friendlyGuacamole;
        private $lib;
        private $pages_registry_filename = '.page.php';

        function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
            global $lib;
            $this->lib = $lib;
        }

        public function register( $page, $path ) {
            $array = array();
            if ( isset($page['id']) ) {
                $array['id'] = $page['id'];
            }
            if ( isset($page['view']) ) {
                $array['view'] = array();
                if ( isset($page['view']['templates']) ) {
                    $array['view']['templates'] = array();
                    for ( $n = 0; $n < count($page['view']['templates']); $n++ ) {
                        array_push( $array['view']['templates'], $this->lib->trailing_slash($path).$page['view']['templates'][$n] );
                    }
                }
                if ( isset($page['view']['styles']) ) {
                    $array['view']['styles'] = array();
                    for ( $n = 0; $n < count($page['view']['styles']); $n++ ) {
                        array_push( $array['view']['styles'], $this->lib->trailing_slash($path).$page['view']['styles'][$n] );
                    }
                }
                if ( isset($page['view']['scripts']) ) {
                    $array['view']['scripts'] = array();
                    for ( $n = 0; $n < count($page['view']['scripts']); $n++ ) {
                        array_push( $array['view']['scripts'], $this->lib->trailing_slash($path).$page['view']['scripts'][$n] );
                    }
                }
            }
            $this->pages_registry[$page['id']] = $array;
        }

        // TODO:
        // private function validatePath( ) {
            // when a page is submitted validate it has/or it
            // doesn't a slash (/) at the beginning of the path
        // }

        public function data( $pages_id = null ) {
            if ( !$pages_id ) {
                return $this->pages_registry;
            }
            if ( !isset($this->pages_registry[$pages_id]) ) {
                return false;
            }
            return $this->pages_registry[$pages_id];
        }

        public function html( $pages_id ) {
            if ( !$pages_id ) {
                return false;
            }
            if ( !isset($this->pages_registry[$pages_id]) ) {
                return false;
            }
            global $friendlyGuacamole;
            for ( $n = 0; $n < count($this->pages_registry[$pages_id]['view']['templates']); $n++ ) {
                require($this->pages_registry[$pages_id]['view']['templates'][$n]);
            }
        }

        // Init

        public function init() {
            $this->pages_registry = array();
            $this->friendlyGuacamole->ContentsLoaderModule->load($this->pages_registry_filename);
        }
    }
?>
