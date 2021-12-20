<?php

    include('includes/init.php');

    function createLayout( $path ) {

        $settings = getSettings();

        // Splitting path into path and layout_name
        $layout_name = explode('/', $path);
        $layout_name = $layout_name[count($layout_name) - 1];
        $path = str_replace($layout_name, '', $path);
        // Deleting / at 0 if any
        $path = substr($path, 0, 1) == '/' ? substr($path, 1, strlen($path) - 1) : $path;
        // Deleting trailing slash if any
        $path = substr($path, strlen($path) - 1, 1) == '/' ? substr($path, 0, strlen($path) - 1) : $path;

        $layout_name = str_replace('.layout', '', $layout_name);

        $path = CONTENTS_DIR.$path.'/layouts/'.$layout_name.'.layout/';
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

        include(SCRIPTS_DIR.'models/layout.model.php');

        $LAYOUT_ID = strtoupper($layout_name);
        $layout_model = str_replace('{{LAYOUT_ID}}', $LAYOUT_ID, $layout_model);

        file_put_contents($path.$layout_name.'.layout.php', $layout_model);
        scriptLogger('Creating file: '.$path.$layout_name.'.layout.php');

        file_put_contents($path.'view/script.js', '');
        scriptLogger('Creating file: '.$path.'view/script.js');

        file_put_contents($path.'view/style.scss', '');
        scriptLogger('Creating file: '.$path.'view/style.scss');

        file_put_contents($path.'view/template.php', '{{layout-pointer.main}}');
        scriptLogger('Creating file: '.$path.'view/template.php');

        file_put_contents($path.'i18n/contents/'.str_replace('-', '_', $settings['defaults']['language']).'.json', '{}');
        scriptLogger('Creating file: '.$path.'i18n/contents/'.str_replace('-', '_', $settings['defaults']['language']).'.json');

        scriptLogger('Layout created successfully');
        scriptLogger('Layout ID: LAYOUT_'.$LAYOUT_ID);
    }

    scriptLogger('Creating layout '.$argv[1]);
    createLayout($argv[1]);

?>