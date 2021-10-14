<?php

    include('../_core/_.php');
    $friendlyGuacamole->init();

    echo '<p>$friendlyGuacamole->ModuleComponentLoader->get_components()</p>';
    echo '<pre>';
    var_dump( $friendlyGuacamole->ModuleComponentLoader->get_components() );
    echo '</pre>';

    echo '<p>$friendlyGuacamole->ModuleComponentRegistry->get()</p>';
    echo '<pre>';
    var_dump( $friendlyGuacamole->ModuleComponentRegistry->get() );
    echo '</pre>';

?>
