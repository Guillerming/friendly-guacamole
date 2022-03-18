<?php

    class ComponentsModule {

        private $components_registry;

        private $friendlyGuacamole;
        private $lib;
        private $dir;
        private $components_registry_filename = '_component.register.php';

        function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
            global $lib;
            $this->lib = $lib;
            global $dir;
            $this->dir = $dir;
        }

        public function register( $component, $path ) {
            $array = array();
            if ( isset($component['id']) ) {
                $array['id'] = $component['id'];
            }
            if ( isset($component['view']) ) {
                $array['view'] = array();
                if ( isset($component['view']['templates']) ) {
                    $array['view']['templates'] = array();
                    for ( $n = 0; $n < count($component['view']['templates']); $n++ ) {
                        array_push( $array['view']['templates'], $this->lib->add_trailing_slash($path).$component['view']['templates'][$n] );
                    }
                }
                if ( isset($component['view']['styles']) ) {
                    $array['view']['styles'] = array();
                    for ( $n = 0; $n < count($component['view']['styles']); $n++ ) {
                        array_push( $array['view']['styles'], $this->lib->add_trailing_slash($path).$component['view']['styles'][$n] );
                    }
                }
                if ( isset($component['view']['scripts']) ) {
                    $array['view']['scripts'] = array();
                    for ( $n = 0; $n < count($component['view']['scripts']); $n++ ) {
                        array_push( $array['view']['scripts'], $this->lib->add_trailing_slash($path).$component['view']['scripts'][$n] );
                    }
                }
            }
            $this->components_registry[$component['id']] = $array;
        }

        // TODO:
        // private function validatePath( ) {
            // when a page is submitted validate it has/or it
            // doesn't a slash (/) at the beginning of the path
        // }

        public function data( $component_id = null ) {
            if ( !$component_id ) {
                return $this->components_registry;
            }
            if ( !isset($this->components_registry[$component_id]) ) {
                return false;
            }
            return $this->components_registry[$component_id];
        }

        public function html( $component_id ) {
            if ( !$component_id ) {
                return false;
            }
            if ( !isset($this->components_registry[$component_id]) ) {
                return false;
            }
            // Preparing vars
            $component_tagname = $this->lib->create_wrapper_tagname($component_id);
            // Preparing component capsule (wrapper)
            $component_wrapper = $this->lib->create_wrapper_attr('component');
            // Get scripts
            $component_scripts = $this->friendlyGuacamole->ScriptsModule->get($component_tagname, $component_wrapper);
            // HTML output
            $output = '';
            $output .= '<'.$component_tagname.' '.$component_wrapper.'>';
            ob_start(null, 0, PHP_OUTPUT_HANDLER_FLUSHABLE | PHP_OUTPUT_HANDLER_REMOVABLE);
            global $friendlyGuacamole;
            for ( $n = 0; $n < count($this->components_registry[$component_id]['view']['templates']); $n++ ) {
                require($this->components_registry[$component_id]['view']['templates'][$n]);
                $output .= ob_get_contents();
            }
            ob_end_clean();
            // Append layout tag wrapper
            $output .= $component_scripts.'</'.$component_tagname.'>';
            return $output;
        }

        // Init

        public function init() {
            $this->components_registry = array();
            $this->friendlyGuacamole->ContentsLoaderModule->load($this->components_registry_filename);
        }
    }

?>
