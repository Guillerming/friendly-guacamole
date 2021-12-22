<?php

    $component_model  = '<?php'."\r";
    $component_model .= '    global $lib;'."\r";
    $component_model .= '    global $friendlyGuacamole;'."\r";
    $component_model .= '    $component = $lib->load_json_file(__DIR__.\'/_component.data.json\');'."\r";
    $component_model .= '    $friendlyGuacamole->ComponentsModule->register($component, __DIR__);'."\r";
    $component_model .= '?>'."\r";

?>