<?php

    // Load App
    require_once('../_core/app.php');
    // Init app + alias
    $friendlyGuacamole->init();
    $fg = $friendlyGuacamole;

    echo $friendlyGuacamole->RenderModule->render();
    exit;

    // Testing
    echo '<p>PagesModule:</p>';
    echo '<pre>';
    var_dump( $fg->PagesModule->data() );
    echo '</pre>';

    echo '<p>ComponentsModule:</p>';
    echo '<pre>';
    var_dump( $fg->ComponentsModule->data() );
    echo '</pre>';

    echo '<p>LayoutsModule:</p>';
    echo '<pre>';
    var_dump( $fg->LayoutsModule->data() );
    echo '</pre>';

    echo '<p>HttpModule:</p>';
    echo '<pre>';
    var_dump( $fg->HttpModule->http );
    echo '</pre>';

    echo '<p>RouterModule:</p>';
    echo '<pre>';
    var_dump( $fg->RouterModule->routes );
    echo '</pre>';

    echo '<p>RouterModule state:</p>';
    echo '<pre>';
    var_dump($fg->RouterModule->state);
    echo '</pre>';

    echo '<p>Settings:</p>';
    echo '<pre>';
    var_dump($fg->SETTINGS);
    echo '</pre>';

?>