<?php

    include('includes/init.php');

    function createComponent( $path ) {
        global $dir;
        global $scriptsLib;

        $settings = $scriptsLib->getSettings();

        // Splitting path into path and component_name
        $component_name = explode('/', $path);
        $component_name = $component_name[count($component_name) - 1];
        $path = str_replace($component_name, '', $path);
        // Deleting / at 0 if any
        $path = substr($path, 0, 1) == '/' ? substr($path, 1, strlen($path) - 1) : $path;
        // Deleting trailing slash if any
        $path = substr($path, strlen($path) - 1, 1) == '/' ? substr($path, 0, strlen($path) - 1) : $path;

        if ( !$path ) {
            $path = 'components/';
        }

        $component_name = str_replace('.component', '', $component_name);

        $path = $dir->contents.$path.'/'.$component_name.'.component/';
        $path = str_replace('//', '/', $path);

        if ( !is_dir( $path ) ) {
            mkdir( $path, 0777, true );
            mkdir( $path.'i18n', 0777, true );
        } else {
            $scriptsLib->scriptLogger($path.' already exists.');
            exit(1);
        }

        include($dir->core.'scripts/models/component.data.model.php');
        include($dir->core.'scripts/models/component.model.php');

        $COMPONENT_ID = strtoupper($component_name);
        $component_name .= '.component';
        $component_data_model = str_replace('{{COMPONENT_NAME}}', $component_name, $component_data_model);
        $component_data_model = str_replace('{{COMPONENT_ID}}', $COMPONENT_ID, $component_data_model);

        file_put_contents($path.'_component.data.json', $component_data_model);
        $scriptsLib->scriptLogger('Creating file: '.$path.'_component.data.json');

        file_put_contents($path.'_component.register.php', $component_model);
        $scriptsLib->scriptLogger('Creating file: '.$path.'_component.register.php');

        file_put_contents($path.$component_name.'.js', '');
        $scriptsLib->scriptLogger('Creating file: '.$path.$component_name.'.js');

        file_put_contents($path.$component_name.'.scss', '');
        $scriptsLib->scriptLogger('Creating file: '.$path.$component_name.'.scss');

        file_put_contents($path.$component_name.'.php', 'COMPONENT_'.$COMPONENT_ID);
        $scriptsLib->scriptLogger('Creating file: '.$path.$component_name.'.php');

        file_put_contents($path.'i18n/'.$settings['defaults']['language'].'.json', '{}');
        $scriptsLib->scriptLogger('Creating file: '.$path.'i18n/'.$settings['defaults']['language'].'.json');

        $scriptsLib->scriptLogger('Component created successfully');
        $scriptsLib->scriptLogger('Component ID: COMPONENT_'.$COMPONENT_ID);
    }

    $scriptsLib->scriptLogger('Creating component '.$argv[1]);
    createComponent($argv[1]);

?>