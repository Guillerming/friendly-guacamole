<?php

    include('includes/init.php');

    function createLayout( $path ) {
        global $dir;
        global $scriptsLib;

        $settings = $scriptsLib->getSettings();

        // Splitting path into path and layout_name
        $layout_name = explode('/', $path);
        $layout_name = $layout_name[count($layout_name) - 1];
        $path = str_replace($layout_name, '', $path);
        // Deleting / at 0 if any
        $path = substr($path, 0, 1) == '/' ? substr($path, 1, strlen($path) - 1) : $path;
        // Deleting trailing slash if any
        $path = substr($path, strlen($path) - 1, 1) == '/' ? substr($path, 0, strlen($path) - 1) : $path;

        $layout_name = str_replace('.layout', '', $layout_name);

        $path = $dir->contents.$path.'/layouts/'.$layout_name.'.layout/';
        $path = str_replace('//', '/', $path);

        if ( !is_dir( $path ) ) {
            mkdir( $path, 0777, true );
            mkdir( $path.'i18n', 0777, true );
        } else {
            $scriptsLib->scriptLogger($path.' already exists.');
            exit(1);
        }

        include($dir->core.'scripts/models/layout.data.model.php');
        include($dir->core.'scripts/models/layout.model.php');

        $LAYOUT_ID = strtoupper($layout_name);
        $layout_name .= '.layout';
        $layout_data_model = str_replace('{{LAYOUT_NAME}}', $layout_name, $layout_data_model);
        $layout_data_model = str_replace('{{LAYOUT_ID}}', $LAYOUT_ID, $layout_data_model);

        file_put_contents($path.'_layout.data.json', $layout_data_model);
        $scriptsLib->scriptLogger('Creating file: '.$path.'_layout.data.json');

        file_put_contents($path.'_layout.register.php', $layout_model);
        $scriptsLib->scriptLogger('Creating file: '.$path.'_layout.register.php');

        file_put_contents($path.$layout_name.'.js', '');
        $scriptsLib->scriptLogger('Creating file: '.$path.$layout_name.'.js');

        file_put_contents($path.$layout_name.'.scss', '');
        $scriptsLib->scriptLogger('Creating file: '.$path.$layout_name.'.scss');

        file_put_contents($path.$layout_name.'.php', '{{layout-pointer.main}}');
        $scriptsLib->scriptLogger('Creating file: '.$path.$layout_name.'.php');

        file_put_contents($path.'i18n/'.$settings['defaults']['language'].'.json', '{}');
        $scriptsLib->scriptLogger('Creating file: '.$path.'i18n/'.$settings['defaults']['language'].'.json');

        $scriptsLib->scriptLogger('Layout created successfully');
        $scriptsLib->scriptLogger('Layout ID: LAYOUT_'.$LAYOUT_ID);
    }

    $scriptsLib->scriptLogger('Creating layout '.$argv[1]);
    createLayout($argv[1]);

?>