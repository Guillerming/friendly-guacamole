<?php

    class ComponentsModule {

        private $component_registry;
        private $component_index;

        private $friendlyGuacamole;
        private $component_registry_filename = '.component.php';
        private $skipping_files = array('.', '..', '.DS_Store', 'thumbs.db', '.gitkeep', '.gitignore', 'i18n', 'view');

        function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
        }

        // Library

        private function trailing_slash( $string ) {
            if ( substr( $string, strlen($string) - 1, 1 ) != '/' && strlen($string) ) {
                return $string.'/';
            }
            return $string;
        }

        // Component directories autoloader

        private function path_collection_to( $target_type, $path_collection ) {
            for ( $n = 0; $n < count($path_collection); $n++ ) {
                if ( $path_collection[$n] == '' ) { unset($path_collection[$n]); }
            }
            $path_collection = array_values($path_collection);
            if ( $target_type == 'array' ) {
                return $path_collection;
            } else {
                return '/'.$this->trailing_slash( implode('/', $path_collection) );
            }
        }

        private function is_file_to_skip( $filename ) {
            for ( $n = 0; $n < count($this->skipping_files); $n++ ) {
                if ( $this->skipping_files[$n] == $filename ) {
                    return true;
                }
            }
            return false;
        }

        private function is_directory( $path_collection, $directory_content_element ) {
            return is_dir( $this->path_collection_to('string', $path_collection).$directory_content_element );
        }

        private function check_directory( $path_collection ) {

            // Cleaning path_collection
            $path_collection = $this->path_collection_to('array', $path_collection);

            // Getting directory contents
            $directory_contents = scandir( $this->path_collection_to('string', $path_collection) );

            // Looping through contents
            for ( $n = 0; $n < count($directory_contents); $n++ ) {

                if ( $this->is_file_to_skip($directory_contents[$n]) ) {
                    continue;
                } else if ( $this->is_directory( $path_collection, $directory_contents[$n] ) ) {
                    $this->dive( $directory_contents[$n], $path_collection );
                } else {
                    $this->add( $directory_contents[$n], $path_collection );
                }

            }

        }

        private function dive( $directory_to_dive_in, $path_collection ) {
            array_push($path_collection, $directory_to_dive_in);
            $this->check_directory( $path_collection );
        }

        private function add( $filename, $path_collection ) {
            if ( strpos($filename, $this->component_registry_filename) === false ) { return; }
            array_push($this->component_index, array('path_collection' => $path_collection, 'file' => $filename));
        }

        private function read_directories() {
            $path_collection = explode('/', $this->friendlyGuacamole->CODE_DIR);
            $this->check_directory( $path_collection );
        }

        private function require_components() {
            for ( $n = 0; $n < count($this->component_index); $n++ ) {
                require_once( $this->path_collection_to('string', $this->component_index[$n]['path_collection']).$this->component_index[$n]['file'] );
            }
        }

        // Manipulate components registry

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
            $this->component_registry[$component['id']] = $array;
        }

        // TODO: private validatePath -> when a component is submitted validate it has/or it doesn't a slash (/) at the beginning of the path

        public function data( $component_id = null ) {
            if ( !$component_id ) {
                return $this->component_registry;
            }
            if ( !isset($this->component_registry[$component_id]) ) {
                return false;
            }
            return $this->component_registry[$component_id];
        }

        public function html( $component_id ) {
            if ( !$component_id ) {
                return false;
            }
            if ( !isset($this->component_registry[$component_id]) ) {
                return false;
            }
            // global $friendlyGuacamole;
            for ( $n = 0; $n < count($this->component_registry[$component_id]['view']['templates']); $n++ ) {
                require_once($this->component_registry[$component_id]['view']['templates'][$n]);
            }
        }

        // Init

        public function init() {
            $this->component_registry = array();
            $this->component_index = array();
            $this->read_directories();
            $this->require_components();
        }
    }
?>
