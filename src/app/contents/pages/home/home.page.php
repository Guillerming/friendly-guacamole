<?php

    (function() {

        global $friendlyGuacamole;

        $page = array(
            'id' => 'PAGE_HOME',
            'layout' => array(
                'id' => 'LAYOUT_PUBLIC',
                'pointers' => array(
                    'main' => array(
                        'templates' => array('view/main/template.php'),
                        'styles' => array('view/main/style.scss'),
                        'scripts' => array('view/main/script.js')
                    ),
                )
            ),
            'route' => array(
                'id' => 'ROUTE_HOME',
                'method' => 'GET'
            )
        );

        $friendlyGuacamole->PagesModule->register($page, __DIR__);

    })();

?>