<?php

    (function() {

        global $friendlyGuacamole;

        $component = array(
            'id' => 'COMPONENT_HEADER',
            'view' => array(
                'templates' => array('view/template.php'),
                'styles' => array('view/style.scss'),
                'scripts' => array('view/script.js')
            )
        );

        $friendlyGuacamole->ModuleComponentRegistry->add($component, __DIR__);

    })();

?>