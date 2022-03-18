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
     * The following script will generate a json file with all the .css/.scss files
     * existing in the registered entities /layouts/pages/components
     */

    function remove_build_dir( $path ) {
        global $dir;
        return str_replace($dir->build.'app/', '', $path);
    }

    function trim_css_extension( $path ) {
        if ( substr( $path, strlen($path) - 4, 4 ) == '.css' ) {
            return substr( $path, 0, strlen($path) - 4 );
        }
        return $path;
    }

    // Composes the temp.styles.json file
    function compose_json_file() {

        global $dir;
        global $fg;

        // Importing settings file
        $settings = $fg->SETTINGS;

        // Styles
        $styles = array();

        // $scriptsLib->scriptLogger( $lib->pretty_print_json( $fg->LayoutsModule->data() ) );
        // $scriptsLib->scriptLogger( $lib->pretty_print_json( $fg->PagesModule->data() ) );
        // $scriptsLib->scriptLogger( $lib->pretty_print_json( $fg->ComponentsModule->data() ) );

        // Vendor
        $styles['vendor'] = array();
        for ( $n = 0; $n < count($settings['dependencies']['styles']); $n++ ) {
            $styles['vendor'][$n] = $dir->app.trim_css_extension($settings['dependencies']['styles'][$n]);
        }

        // Layouts
        $styles['layouts'] = array();
        foreach( $fg->LayoutsModule->data() as $layout ) {
            array_push($styles['layouts'], [
                'id' => strtolower($layout['id']),
                'styles' => $layout['view']['styles'],
            ]);
        }

        // Pages
        $styles['pages'] = array();
        foreach( $fg->PagesModule->data() as $page ) {
            $page_styles = array();
            foreach ( $page['layout']['pointers'] as $pointer => $data ) {
                $array = [
                    'pointer' => $pointer,
                    'files' => $data['styles']
                ];
                array_push($page_styles, $array);
            }
            array_push($styles['pages'], [
                'id' => strtolower($page['id']),
                'styles' => $page_styles,
            ]);
        }

        // Components
        $styles['components'] = array();
        foreach( $fg->ComponentsModule->data() as $component ) {
            array_push($styles['components'], [
                'id' => strtolower($component['id']),
                'styles' => $component['view']['styles'],
            ]);
        }

        // Replacing all $dir->app by $dir->build
        $styles_json = json_encode($styles);
        $styles_json = str_replace('\/', '/', $styles_json);
        $styles_json = str_replace($dir->app, $dir->build.'app/', $styles_json);
        $styles = json_decode($styles_json, true);

        return $styles;

    }

    // Composes the temp.styles.scss file
    function compose_scss_file( $styles ) {

        global $fg;
        global $lib;

        // Preparing .scss file
        $scss = '';

        // Vendor
        foreach( $styles['vendor'] as $vendor ) {
            $scss .= '@import "'.remove_build_dir($vendor).'";'."\n";
        }

        // Layouts
        foreach( $styles['layouts'] as $layout ) {
            $scss .= $lib->create_wrapper_tagname($layout['id']).' {'."\n";
            for ( $n = 0; $n < count($layout['styles']); $n++ ) {
                $scss .= '  @import "'.remove_build_dir($layout['styles'][$n]).'";'."\n";
            }
            $scss .= '}'."\n";
        }

        // Pages
        foreach( $styles['pages'] as $page ) {
            for ( $n = 0; $n < count($page['styles']); $n++ ) {
                $scss .= $lib->create_wrapper_tagname($page['id'], $page['styles'][$n]['pointer']).' {'."\n";
                for ( $i = 0; $i < count($page['styles'][$n]['files']); $i++ ) {
                    $scss .= '  @import "'.remove_build_dir($page['styles'][$n]['files'][$i]).'";'."\n";
                }
                $scss .= '}'."\n";
            }
        }

        // Components
        foreach( $styles['components'] as $component ) {
            $scss .= $fg->SETTINGS['wrapper']['prefix'].str_replace('_', '-', $component['id']).' {'."\n";
            for ( $n = 0; $n < count($component['styles']); $n++ ) {
                $scss .= '  @import "'.remove_build_dir($component['styles'][$n]).'";'."\n";
            }
            $scss .= '}'."\n";
        }

        return $scss;
    }

    // The script itself
    function extract_styles() {

        global $scriptsLib;
        global $dir;
        global $lib;

        // target dir
        $config = array(
            'target' => array(
                'dir' => $dir->build.'app/',
                'filename' => 'temp.styles'
            ),
        );

        // Create target dir if not exists
        if (!file_exists($config['target']['dir'])) {
            mkdir($config['target']['dir'], 0777, true);
        }

        $styles = compose_json_file();
        $scss = compose_scss_file( $styles );

        $stored = array();
        // Saving reference json
        $stored['json'] = file_put_contents( $config['target']['dir'].$config['target']['filename'].'.json', $lib->pretty_print_json($styles) );
        // Saving .scss file
        $stored['scss'] = file_put_contents( $config['target']['dir'].$config['target']['filename'].'.scss', $scss );

        if ( $stored['json'] && $stored['scss'] ) {
            $scriptsLib->scriptLogger('Done');
            $scriptsLib->scriptLogger('------');
            exit(0);
        } else {
            $scriptsLib->scriptLogger('Something went wrong:');
            $scriptsLib->scriptLogger('JSON file: '.$stored['json']);
            $scriptsLib->scriptLogger('SCSS file: '.$stored['scss']);
            $scriptsLib->scriptLogger('------');
            exit(1);
        }
    }

    // Run!
    $scriptsLib->scriptLogger('Extracting styles');
    extract_styles();
