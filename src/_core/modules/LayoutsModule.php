<?php

    class LayoutsModule {

        private $layouts_registry;

        private $friendlyGuacamole;
        private $lib;
        private $layouts_registry_filename = '.layout.php';

        function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
            global $lib;
            $this->lib = $lib;
        }

        public function register( $layout, $path ) {
            // Trim path
            $path = str_replace( $this->friendlyGuacamole->HOME_DIR, '', $path );
            $array = array();
            if ( isset($layout['id']) ) {
                $array['id'] = $layout['id'];
            }
            if ( isset($layout['view']) ) {
                $array['view'] = array();
                if ( isset($layout['view']['templates']) ) {
                    $array['view']['templates'] = array();
                    for ( $n = 0; $n < count($layout['view']['templates']); $n++ ) {
                        array_push( $array['view']['templates'], $this->lib->add_trailing_slash($path).$layout['view']['templates'][$n] );
                    }
                }
                if ( isset($layout['view']['styles']) ) {
                    $array['view']['styles'] = array();
                    for ( $n = 0; $n < count($layout['view']['styles']); $n++ ) {
                        array_push( $array['view']['styles'], $this->lib->add_trailing_slash($path).$layout['view']['styles'][$n] );
                    }
                }
                if ( isset($layout['view']['scripts']) ) {
                    $array['view']['scripts'] = array();
                    for ( $n = 0; $n < count($layout['view']['scripts']); $n++ ) {
                        array_push( $array['view']['scripts'], $this->lib->add_trailing_slash($path).$layout['view']['scripts'][$n] );
                    }
                }
            }
            $this->layouts_registry[$layout['id']] = $array;
        }

        // TODO:
        // private function validatePath( ) {
            // when a layout is submitted validate it has/or it
            // doesn't a slash (/) at the beginning of the path
        // }

        public function data( $layout_id = null ) {
            if ( !$layout_id ) {
                return $this->layouts_registry;
            }
            if ( !isset($this->layouts_registry[$layout_id]) ) {
                return false;
            }
            return $this->layouts_registry[$layout_id];
        }

        public function html( $layout_id ) {
            if ( !$layout_id ) {
                return false;
            }
            if ( !isset($this->layouts_registry[$layout_id]) ) {
                return false;
            }
            // Loading layout templates
            $output = '';
            ob_start();
            global $friendlyGuacamole;
            for ( $n = 0; $n < count($this->layouts_registry[$layout_id]['view']['templates']); $n++ ) {
                require($this->friendlyGuacamole->BUILD_DIR.$this->layouts_registry[$layout_id]['view']['templates'][$n]);
                $output .= ob_get_contents();
            }
            ob_clean();
            // Replacing pointers
            $pointers = $this->friendlyGuacamole->RouterModule->state['controller']['layout']['pointers'];
            foreach ( $pointers as $pointer => $data ) {
                // Loading templates for current pointer
                $templates = '';
                ob_start();
                for ( $i = 0; $i < count($data['templates']); $i++ ) {
                    require( $this->friendlyGuacamole->BUILD_DIR.$data['templates'][$i] );
                    $templates .= ob_get_contents();
                }
                ob_clean();
                // Replacing pointers with loaded templates
                $output = str_replace( '{{layout-pointer.'.$pointer.'}}', $templates, $output );
            }
            // Returning html
            return $output;
        }

        // Init

        public function init() {
            $this->layouts_registry = array();
            $this->friendlyGuacamole->ContentsLoaderModule->load($this->layouts_registry_filename);
        }
    }
?>
