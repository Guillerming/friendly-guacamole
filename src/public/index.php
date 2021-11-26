<?php

    require('../_core/app.php');
    $friendlyGuacamole->init();

    echo '<p>$friendlyGuacamole->ComponentsModule->data()</p>';
    echo '<pre>';
    var_dump( $friendlyGuacamole->ComponentsModule->data() );
    echo '</pre>';

    // $friendlyGuacamole->ComponentsModule->html('COMPONENT_FOOTER');

?>