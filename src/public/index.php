<?php

    // Load App
    require_once('../_core/app.php');
    // Init app + alias
    $friendlyGuacamole->init();
    $fg = $friendlyGuacamole;

    // Testing
    echo '<p>$fg->PagesModule->data()</p>';
    echo '<pre>';
    var_dump( $fg->PagesModule->data() );
    echo '</pre>';
    echo '<p>$fg->ComponentsModule->data()</p>';
    echo '<pre>';
    var_dump( $fg->ComponentsModule->data() );
    echo '</pre>';

    $fg->ComponentsModule->html('COMPONENT_HEADER');
    $fg->ComponentsModule->html('COMPONENT_FOOTER');

?>