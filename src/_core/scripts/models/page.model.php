<?php

    $page_model  = '<?php '."\r";
    $page_model .= "\r";
    $page_model .= '    (function() {'."\r";
    $page_model .= "\r";
    $page_model .= '        global $friendlyGuacamole;'."\r";
    $page_model .= "\r";
    $page_model .= '        $page = array('."\r";
    $page_model .= '            \'id\' => \'PAGE_{{PAGE_ID}}\','."\r";
    $page_model .= '            \'layout\' => array('."\r";
    $page_model .= '                \'id\' => \'LAYOUT_PUBLIC\','."\r";
    $page_model .= '                \'pointers\' => array('."\r";
    $page_model .= '                    \'main\' => array('."\r";
    $page_model .= '                        \'templates\' => array(\'view/main/template.php\'),'."\r";
    $page_model .= '                        \'styles\' => array(\'view/main/style.scss\'),'."\r";
    $page_model .= '                        \'scripts\' => array(\'view/main/script.js\')'."\r";
    $page_model .= '                    )'."\r";
    $page_model .= '                )'."\r";
    $page_model .= '            ),'."\r";
    $page_model .= '            \'route\' => array('."\r";
    $page_model .= '                \'id\' => \'ROUTE_{{PAGE_ID}}\','."\r";
    $page_model .= '                \'id\' => \'GET\','."\r";
    $page_model .= '            ),'."\r";
    $page_model .= '        );'."\r";
    $page_model .= "\r";
    $page_model .= '        $friendlyGuacamole->PagesModule->register($page, __DIR__);'."\r";
    $page_model .= "\r";
    $page_model .= '    })();'."\r";
    $page_model .= "\r";
    $page_model .= '?>'."\r";
    $page_model .= "\r";

?>