<?php

    (function() {

        global $friendlyGuacamole;

        $component = array(
            'id' => 'COMPONENT_FOOTER',
            'view' => array(
                'templates' => array('view/template.php'),
                'styles' => array('view/style.scss'),
                'scripts' => array('view/script.js')
            )
        );

        $friendlyGuacamole->ComponentsModule->register($component, __DIR__);

    })();

?>