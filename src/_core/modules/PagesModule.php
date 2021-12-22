<?php

    class PagesModule {

        private $pages_registry;

        private $friendlyGuacamole;
        private $lib;
        private $pages_registry_filename = '_page.register.php';

        function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
            global $lib;
            $this->lib = $lib;
        }

        public function register( $page, $path ) {
            // TODO: All pages must contain id, pointers, layout and route
            // so verify $page contents and print error if there's anything missing
            // Trim path
            $path = str_replace( $this->friendlyGuacamole->HOME_DIR, '', $path );
            // Init array var
            $array = array();
            // Copy $page contents to $array
            if ( isset($page['id']) ) {
                $array['id'] = $page['id'];
            }
            if ( isset($page['layout']) ) {
                $array['layout'] = $page['layout'];
                // Adding $path to pointers
                foreach ( $array['layout']['pointers'] as $pointer => $data ) {
                    if ( isset($array['layout']['pointers'][$pointer]['templates']) ) {
                        for ( $n = 0; $n < count($array['layout']['pointers'][$pointer]['templates']); $n++ ) {
                            $array['layout']['pointers'][$pointer]['templates'][$n] = $this->lib->add_trailing_slash($path).$data['templates'][$n];
                        }
                    }
                    if ( isset($array['layout']['pointers'][$pointer]['styles']) ) {
                        for ( $n = 0; $n < count($array['layout']['pointers'][$pointer]['styles']); $n++ ) {
                            $array['layout']['pointers'][$pointer]['styles'][$n] = $this->lib->add_trailing_slash($path).$data['styles'][$n];
                        }
                    }
                    if ( isset($array['layout']['pointers'][$pointer]['scripts']) ) {
                        for ( $n = 0; $n < count($array['layout']['pointers'][$pointer]['scripts']); $n++ ) {
                            $array['layout']['pointers'][$pointer]['scripts'][$n] = $this->lib->add_trailing_slash($path).$data['scripts'][$n];
                        }
                    }
                }
            }
            if ( isset($page['route']) ) {
                $array['route'] = $page['route'];
            }
            $this->pages_registry[$page['id']] = $array;
        }

        // TODO:
        // private function validatePath( ) {
            // when a page is submitted validate it has/or it
            // doesn't a slash (/) at the beginning of the path
        // }

        public function data( $page_id = null ) {
            if ( !$page_id ) {
                return $this->pages_registry;
            }
            if ( !isset($this->pages_registry[$page_id]) ) {
                return false;
            }
            return $this->pages_registry[$page_id];
        }

        public function html( $page_id ) {
            if ( !$page_id ) {
                return false;
            }
            if ( !isset($this->pages_registry[$page_id]) ) {
                return false;
            }
            $output = '';
            ob_start(null, 0, PHP_OUTPUT_HANDLER_FLUSHABLE | PHP_OUTPUT_HANDLER_REMOVABLE);
            global $friendlyGuacamole;
            foreach ( $this->pages_registry[$page_id]['layout']['pointers'] as $pointer => $data) {
                for ( $n = 0; $n < count($data['templates']); $n++ ) {
                    require($this->friendlyGuacamole->BUILD_DIR.$data['templates'][$n]);
                    // $output .= ob_get_contents();
                }
            }
            // ob_clean();
            ob_end_flush();
            return $output;
        }

        // Init

        public function init() {
            $this->pages_registry = array();
            $this->friendlyGuacamole->ContentsLoaderModule->load($this->pages_registry_filename);
        }
    }
?>
