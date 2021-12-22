<?php

    include('includes/init.php');

    function createPage( $path ) {

        $settings = getSettings();

        // Splitting path into path and page_name
        $page_name = explode('/', $path);
        $page_name = $page_name[count($page_name) - 1];
        $path = str_replace($page_name, '', $path);
        // Deleting / at 0 if any
        $path = substr($path, 0, 1) == '/' ? substr($path, 1, strlen($path) - 1) : $path;
        // Deleting trailing slash if any
        $path = substr($path, strlen($path) - 1, 1) == '/' ? substr($path, 0, strlen($path) - 1) : $path;

        $page_name = str_replace('.page', '', $page_name);

        $path = CONTENTS_DIR.'/pages/'.$path.'/'.$page_name.'.page/';
        $path = str_replace('//', '/', $path);

        if ( !is_dir( $path ) ) {
            mkdir( $path, 0777, true );
            mkdir( $path.'i18n', 0777, true );
        } else {
            scriptLogger($path.' already exists.');
            exit(1);
        }

        include(SCRIPTS_DIR.'models/page.data.model.php');
        include(SCRIPTS_DIR.'models/page.model.php');

        $PAGE_ID = strtoupper($page_name);
        $page_name .= '.page';
        $page_data_model = str_replace('{{PAGE_NAME}}', $page_name, $page_data_model);
        $page_data_model = str_replace('{{PAGE_ID}}', $PAGE_ID, $page_data_model);

        file_put_contents($path.'_page.data.json', $page_data_model);
        scriptLogger('Creating file: '.$path.'_page.data.json');

        file_put_contents($path.'_page.register.php', $page_model);
        scriptLogger('Creating file: '.$path.'_page.register.php');

        file_put_contents($path.$page_name.'.js', '');
        scriptLogger('Creating file: '.$path.$page_name.'.js');

        file_put_contents($path.$page_name.'.scss', '');
        scriptLogger('Creating file: '.$path.$page_name.'.scss');

        file_put_contents($path.$page_name.'.php', 'PAGE_'.$PAGE_ID);
        scriptLogger('Creating file: '.$path.$page_name.'.php');

        file_put_contents($path.'i18n/'.$settings['defaults']['language'].'.json', '{}');
        scriptLogger('Creating file: '.$path.'i18n/'.$settings['defaults']['language'].'.json');

        scriptLogger('Component created successfully');
        scriptLogger('Component ID: PAGE_'.$PAGE_ID);
    }

    scriptLogger('Creating page '.$argv[1]);
    createPage($argv[1]);

?>