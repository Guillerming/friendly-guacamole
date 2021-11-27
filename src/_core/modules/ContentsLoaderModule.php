<?php

    class ContentsLoaderModule {

        private $lib;
        private $friendlyGuacamole;
        private $code_elements;

        private $ignore_files = [
            '.', '..',
            '.DS_Store',
            'thumbs.db',
            '.gitkeep',
            '.gitignore',
            'i18n',
            'view'
        ];

        function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
            global $lib;
            $this->lib = $lib;
        }

        // Private methods

        private function ignore_file( $filename ) {
            for ( $n = 0; $n < count($this->ignore_files); $n++ ) {
                if ( $this->ignore_files[$n] == $filename ) {
                    return true;
                }
            }
            return false;
        }

        private function is_directory( $path_collection, $directory_content_element ) {
            return is_dir( $this->convert($path_collection, 'string').$directory_content_element );
        }

        private function check_directory( $path_collection ) {

            // Cleaning path_collection
            $path_collection = $this->convert($path_collection, 'array');

            // Getting directory contents
            $directory_contents = scandir( $this->convert($path_collection, 'string') );

            // Looping through contents
            for ( $n = 0; $n < count($directory_contents); $n++ ) {

                if ( $this->ignore_file($directory_contents[$n]) ) {
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
            if ( strpos($filename, $this->code_elements_filename) === false ) { return; }
            array_push($this->code_elements, array('path_collection' => $path_collection, 'file' => $filename));
        }

        private function require_elements() {
            for ( $n = 0; $n < count($this->code_elements); $n++ ) {
                require_once( $this->convert($this->code_elements[$n]['path_collection'], 'string').$this->code_elements[$n]['file'] );
            }
        }

        // Public methods

        public function convert( $path_collection, $target_type ) {
            for ( $n = 0; $n < count($path_collection); $n++ ) {
                if ( $path_collection[$n] == '' ) { unset($path_collection[$n]); }
            }
            $path_collection = array_values($path_collection);
            if ( $target_type == 'array' ) {
                return $path_collection;
            } else if ( $target_type == 'string' ) {
                return '/'.$this->lib->add_trailing_slash( implode('/', $path_collection) );
            }
        }

        public function load( $target_file_name ) {
            $this->code_elements = array();
            $this->code_elements_filename = $target_file_name;
            $this->check_directory( explode('/', $this->friendlyGuacamole->CONTENTS_DIR) );
            $this->require_elements();
        }
    }
?>
