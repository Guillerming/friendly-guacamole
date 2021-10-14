<?php

    class ComponentLoader {

        private $component_registry_filename = '_component.php';
        private $components_dirname;
        private $app_dir;
        private $skipping_files;
        private $components;

        function __construct() {
            global $friendlyGuacamole;
            $this->app_dir = $friendlyGuacamole->APP_DIR;
            $this->components_dirname = 'components';
            $this->skipping_files = array('.', '..', '.DS_Store', 'thumbs.db', '.gitkeep', '.gitignore', 'i18n', 'view');
            $this->components = [];
        }

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

        private function trailing_slash( $string ) {
            if ( substr( $string, strlen($string) - 1, 1 ) != '/' && strlen($string) ) {
                return $string.'/';
            }
            return $string;
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
            if ( $filename != $this->component_registry_filename ) { return; }
            array_push($this->components, array('path_collection' => $path_collection, 'file' => $filename));
        }

        private function read_directories() {
            $path_collection = explode('/', $this->app_dir);
            array_push($path_collection, $this->components_dirname);
            $this->check_directory( $path_collection );
        }

        public function init() {
            $this->read_directories();
        }

        public function load() {
            for ( $n = 0; $n < count($this->components); $n++ ) {
                include( $this->path_collection_to('string', $this->components[$n]['path_collection']).$this->components[$n]['file'] );
            }
        }

        public function get_components() {
            return $this->components;
        }

    }

?>