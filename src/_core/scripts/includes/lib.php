<?php

    class ScriptsLib {

        function __construct() {}

        public function getSettings() {
            global $dir;
            return json_decode(file_get_contents($dir->app.'settings.json'), true);
        }

        public function scriptLogger( $log ) {
            echo $log."\n";
        }

        public function find_files( $path, $regex ) {

            function convert( $path_collection, $target_type ) {
                global $lib;
                for ( $n = 0; $n < count($path_collection); $n++ ) {
                    if ( $path_collection[$n] == '' ) { unset($path_collection[$n]); }
                }
                $path_collection = array_values($path_collection);
                if ( $target_type == 'array' ) {
                    return $path_collection;
                } else if ( $target_type == 'string' ) {
                    return '/'.$lib->add_trailing_slash( implode('/', $path_collection) );
                }
            }

            function ignore_file( $filename ) {
                static $ignore_files = [
                    '.', '..',
                    '.DS_Store',
                    'thumbs.db',
                    '.gitkeep',
                    '.gitignore',
                ];
                for ( $n = 0; $n < count($ignore_files); $n++ ) {
                    if ( $ignore_files[$n] == $filename ) {
                        return true;
                    }
                }
                return false;
            }

            function is_directory( $path_collection, $directory_content_element ) {
                return is_dir( convert($path_collection, 'string').$directory_content_element );
            }

            function dive( $directory_to_dive_in, $path_collection, $regex ) {
                array_push($path_collection, $directory_to_dive_in);
                check_directory( $path_collection, $regex );
            }

            function check_directory($path_collection, $regex ) {

                static $files = [];

                // Cleaning path_collection
                $path_collection = convert($path_collection, 'array');

                // Getting directory contents
                $directory_contents = scandir( convert($path_collection, 'string') );

                if ( !$directory_contents ) {
                    $directory_contents = array();
                }

                // Looping through contents
                for ( $n = 0; $n < count($directory_contents); $n++ ) {
                    if ( ignore_file($directory_contents[$n]) ) {
                        continue;
                    } else if ( is_directory( $path_collection, $directory_contents[$n] ) ) {
                        dive( $directory_contents[$n], $path_collection, $regex );
                    } else {
                        if ( preg_match($regex, $directory_contents[$n]) ) {
                            // add( convert($path_collection, 'string').$directory_contents[$n] );
                            array_push($files, convert($path_collection, 'string').$directory_contents[$n]);
                        }
                    }
                }

                return $files;
            }

            return check_directory( explode('/', $path), $regex );
        }
    }

    $scriptsLib = new ScriptsLib;
