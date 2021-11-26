<?php

    (function() {

        global $friendlyGuacamole;

        $layout = array(
            'id' => 'LAYOUT_PUBLIC',
            'view' => array(
                'templates' => array('view/template.php'),
                'styles' => array('view/style.scss'),
                'scripts' => array('view/script.js')
            )
        );

        $friendlyGuacamole->LayoutsModule->register($layout, __DIR__);

    })();

?>