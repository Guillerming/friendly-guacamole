<?php

    include('includes/init.php');

    function createComponent( $path ) {

        $settings = getSettings();

        // Splitting path into path and component_name
        $component_name = explode('/', $path);
        $component_name = $component_name[count($component_name) - 1];
        $path = str_replace($component_name, '', $path);
        // Deleting / at 0 if any
        $path = substr($path, 0, 1) == '/' ? substr($path, 1, strlen($path) - 1) : $path;
        // Deleting trailing slash if any
        $path = substr($path, strlen($path) - 1, 1) == '/' ? substr($path, 0, strlen($path) - 1) : $path;

        if ( !$path ) {
            $path = 'ui/';
        }

        $component_name = str_replace('.component', '', $component_name);

        $path = CONTENTS_DIR.$path.'/'.$component_name.'.component/';
        $path = str_replace('//', '/', $path);

        if ( !is_dir( $path ) ) {
            mkdir( $path, 0777, true );
            mkdir( $path.'i18n', 0777, true );
            mkdir( $path.'i18n/contents', 0777, true );
            mkdir( $path.'view', 0777, true );
        } else {
            scriptLogger($path.' already exists.');
            exit(1);
        }

        include(SCRIPTS_DIR.'models/component.model.php');

        $COMPONENT_ID = strtoupper($component_name);
        $component_model = str_replace('{{COMPONENT_ID}}', $COMPONENT_ID, $component_model);

        file_put_contents($path.$component_name.'.component.php', $component_model);
        scriptLogger('Creating file: '.$path.$component_name.'.component.php');

        file_put_contents($path.'view/script.js', '');
        scriptLogger('Creating file: '.$path.'view/script.js');

        file_put_contents($path.'view/style.scss', '');
        scriptLogger('Creating file: '.$path.'view/style.scss');

        file_put_contents($path.'view/template.php', $COMPONENT_ID);
        scriptLogger('Creating file: '.$path.'view/template.php');

        file_put_contents($path.'i18n/contents/'.str_replace('-', '_', $settings['defaults']['language']).'.json', '{}');
        scriptLogger('Creating file: '.$path.'i18n/contents/'.str_replace('-', '_', $settings['defaults']['language']).'.json');

        scriptLogger('Component created successfully');
        scriptLogger('Component ID: COMPONENT_'.$COMPONENT_ID);
    }

    scriptLogger('Creating component '.$argv[1]);
    createComponent($argv[1]);

?>