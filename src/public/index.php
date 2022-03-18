<?php

    // Config
    $debug = false;

    // Load App
    require_once('../_core/dir.php');
    require_once($dir->core.'app.php');
    // Init app
    $friendlyGuacamole->init();

    // Print contents
    echo $friendlyGuacamole->RenderModule->render();

    if ( !$debug ) { exit; }

    echo '<style>h3 {margin-bottom:15px;} pre {display:block;padding:15px;border-radius:5px;background-color:#ededed;margin-bottom:30px;}</style>';

    echo '<h3>LayoutsModule registry:</h3>';
    echo '<pre>';
    echo $lib->pretty_print_json($fg->LayoutsModule->data());
    echo '</pre>';

    echo '<h3>PagesModule registry:</h3>';
    echo '<pre>';
    echo $lib->pretty_print_json($fg->PagesModule->data());
    echo '</pre>';

    echo '<h3>ComponentsModule registry:</h3>';
    echo '<pre>';
    echo $lib->pretty_print_json($fg->ComponentsModule->data());
    echo '</pre>';

    echo '<hr>';

    echo '<h3>HttpModule:</h3>';
    echo '<pre>';
    echo $lib->pretty_print_json($fg->HttpModule->http);
    echo '</pre>';

    echo '<hr>';

    echo '<h3>RouterModule:</h3>';
    echo '<pre>';
    echo $lib->pretty_print_json($fg->RouterModule->routes);
    echo '</pre>';

    echo '<hr>';

    echo '<h3>RouterModule state:</h3>';
    echo '<pre>';
    echo $lib->pretty_print_json($fg->RouterModule->state);
    echo '</pre>';

    echo '<hr>';

    echo '<h3>Settings:</h3>';
    echo '<pre>';
    echo $lib->pretty_print_json($fg->SETTINGS);
    echo '</pre>';

?>