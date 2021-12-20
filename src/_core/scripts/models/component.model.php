<?php

    $component_model  = '<?php '."\r";
    $component_model .= "\r";
    $component_model .= '    (function() {'."\r";
    $component_model .= "\r";
    $component_model .= '        global $friendlyGuacamole;'."\r";
    $component_model .= "\r";
    $component_model .= '        $component = array('."\r";
    $component_model .= '            \'id\' => \'COMPONENT_{{COMPONENT_ID}}\','."\r";
    $component_model .= '            \'view\' => array('."\r";
    $component_model .= '                \'templates\' => array(\'view/template.php\'),'."\r";
    $component_model .= '                \'styles\' => array(\'view/style.scss\'),'."\r";
    $component_model .= '                \'scripts\' => array(\'view/script.js\')'."\r";
    $component_model .= '            )'."\r";
    $component_model .= '        );'."\r";
    $component_model .= "\r";
    $component_model .= '        $friendlyGuacamole->ComponentsModule->register($component, __DIR__);'."\r";
    $component_model .= "\r";
    $component_model .= '    })();'."\r";
    $component_model .= "\r";
    $component_model .= '?>'."\r";
    $component_model .= "\r";

?>