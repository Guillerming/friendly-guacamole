<?php

    (function() {

        global $friendlyGuacamole;

        $page = array(
            'id' => 'PAGE_HOME',
            'view' => array(
                'templates' => array('view/template.php'),
                'styles' => array('view/style.scss'),
                'scripts' => array('view/script.js')
            ),
            'layout' => 'LAYOUT_PUBLIC',
            'route' => array(
                'id' => 'ROUTE_HOME',
                'method' => 'GET'
            )
        );

        $friendlyGuacamole->PagesModule->register($page, __DIR__);

    })();

?>