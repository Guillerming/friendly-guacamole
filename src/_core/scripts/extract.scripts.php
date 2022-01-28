<?php

    /**
     * Script initializer
     * 
     * After this input: $fg, $lib, $dir, $scriptsLib and any other
     * needed class are globally available
     * 
     */

     require_once('includes/init.php');

    /**
     * The following script will generate a json file with all the .js files
     * existing in the registered entities /layouts/pages/components + the
     * vendor files and the js files within contents/ui/scripts
     */

    function remove_build_dir( $path ) {
        global $dir;
        return str_replace($dir->build.'app/', '', $path);
    }

    // Composes the temp.scripts.json file
    function compose_json_file() {

        global $scriptsLib;
        global $lib;
        global $dir;
        global $fg;

        // Importing settings file
        $settings = $fg->SETTINGS;

        // Styles
        $scripts = array(
            'vendor' => array(),
            'user' => array(),
        );

        // $scriptsLib->scriptLogger( $lib->pretty_print_json( $fg->LayoutsModule->data() ) );
        // $scriptsLib->scriptLogger( $lib->pretty_print_json( $fg->PagesModule->data() ) );
        // $scriptsLib->scriptLogger( $lib->pretty_print_json( $fg->ComponentsModule->data() ) );

        // Vendor
        for ( $n = 0; $n < count($settings['dependencies']['scripts']); $n++ ) {
            $scripts['vendor'][$n] = $dir->app.$settings['dependencies']['scripts'][$n];
        }

        // Scripts
        $pattern = '/.*\.js$/';
        // $scriptsLib->scriptLogger('ui: '.$dir->contents.'ui/scripts/');
        $files = $scriptsLib->find_files($dir->contents.'ui/scripts/', $pattern);
        $scripts['vendor'] = array_merge($scripts['vendor'], $files);

        // Layouts
        $scripts_layouts = array();
        foreach( $fg->LayoutsModule->data() as $id => $layout ) {
            array_push($scripts_layouts, [
                'wrapper' => $lib->convert_entity_id_to_wrapper_tagname($id),
                'scripts' => $layout['view']['scripts'],
            ]);
        }
        $scripts['user'] = array_merge($scripts['user'], $scripts_layouts);

        // Pages
        $scripts_pages = array();
        foreach( $fg->PagesModule->data() as $id => $page ) {
            foreach ( $page['layout']['pointers'] as $pointer => $data ) {
                $array = [
                    'wrapper' => $lib->convert_entity_id_to_wrapper_tagname($id, $pointer),
                    'files' => $data['scripts']
                ];
                array_push($scripts_pages, $array);
            }
        }
        $scripts['user'] = array_merge($scripts['user'], $scripts_pages);

        // Components
        $scripts_components = array();
        foreach( $fg->ComponentsModule->data() as $id => $component ) {
            $array = [
                'wrapper' => $lib->convert_entity_id_to_wrapper_tagname($id),
                'files' => $component['view']['scripts'],
            ];
            array_push($scripts_components, $array);
        }
        $scripts['user'] = array_merge($scripts['user'], $scripts_components);

        // Replacing all $dir->app by $dir->build
        $scripts_json = json_encode($scripts);
        $scripts_json = str_replace('\/', '/', $scripts_json);
        $scripts_json = str_replace($dir->app, $dir->build.'app/', $scripts_json);
        $scripts = json_decode($scripts_json, true);

        return $scripts;

    }

    // The script itself
    function extract_scripts() {

        global $scriptsLib;
        global $dir;
        global $lib;

        // target dir
        $config = array(
            'target' => array(
                'dir' => $dir->build.'app/',
                'filename' => 'temp.scripts'
            ),
        );

        // Create target dir if not exists
        if (!file_exists($config['target']['dir'])) {
            mkdir($config['target']['dir'], 0777, true);
        }

        $json = compose_json_file();
        // $js = compose_js_file( $json );

        $stored = array();
        // Saving reference json
        $stored['json'] = file_put_contents( $config['target']['dir'].$config['target']['filename'].'.json', $lib->pretty_print_json($json) );
        // Saving .js file
        // $stored['js'] = file_put_contents( $config['target']['dir'].$config['target']['filename'].'.js', $js );

        if ( $stored['json'] ) {
            $scriptsLib->scriptLogger('Done');
            $scriptsLib->scriptLogger('------');
            exit(0);
        } else {
            $scriptsLib->scriptLogger('Something went wrong:');
            $scriptsLib->scriptLogger('JSON file: '.$stored['json']);
            // $scriptsLib->scriptLogger('JS file: '.$stored['js']);
            $scriptsLib->scriptLogger('------');
            exit(1);
        }
    }

    // Run!
    $scriptsLib->scriptLogger('Extracting scripts');
    extract_scripts();
