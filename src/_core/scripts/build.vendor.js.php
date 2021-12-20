<?php

    /*
     * This is the script that will run collecting
     * all the script vendor files listed on settings.json
     * file and storing them where gulp expects to find
     * vendor files to concat and process.
     */

    include('includes/init.php');


    function buildVendorJs() {

        // Importing settings file
        $settings = getSettings();

        // Copy files to build dir
        $copy_files_dir = BUILD_DIR.'vendor/js/';
        if ( !is_dir($copy_files_dir) ) {
            mkdir($copy_files_dir, 0777, true);
        }
        for ( $n = 0; $n < count($settings['dependencies']['scripts']); $n++ ) {
            $path = $settings['dependencies']['scripts'][$n];
            $filename = explode('/', $path);
            $filename = $filename[count($filename) - 1];
            $copied = copy( $path, $copy_files_dir.$filename );
            if ( !$copied ) {
                scriptLogger('Error copying '.$path);
                scriptLogger('------');
                exit(1);
            }
        }

        scriptLogger('Done');
        scriptLogger('------');
        exit(0);
    }


    scriptLogger('Copy vendor JS files');
    buildVendorJs();
?>