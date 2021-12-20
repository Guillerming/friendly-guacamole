<?php

    $layout_model  = '<?php '."\r";
    $layout_model .= "\r";
    $layout_model .= '    (function() {'."\r";
    $layout_model .= "\r";
    $layout_model .= '        global $friendlyGuacamole;'."\r";
    $layout_model .= "\r";
    $layout_model .= '        $layout = array('."\r";
    $layout_model .= '            \'id\' => \'LAYOUT_{{LAYOUT_ID}}\','."\r";
    $layout_model .= '            \'view\' => array('."\r";
    $layout_model .= '                \'templates\' => array(\'view/template.php\'),'."\r";
    $layout_model .= '                \'styles\' => array(\'view/style.scss\'),'."\r";
    $layout_model .= '                \'scripts\' => array(\'view/script.js\')'."\r";
    $layout_model .= '            )'."\r";
    $layout_model .= '        );'."\r";
    $layout_model .= "\r";
    $layout_model .= '        $friendlyGuacamole->LayoutsModule->register($layout, __DIR__);'."\r";
    $layout_model .= "\r";
    $layout_model .= '    })();'."\r";
    $layout_model .= "\r";
    $layout_model .= '?>'."\r";
    $layout_model .= "\r";

?>