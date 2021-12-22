<?php

    $layout_model  = '<?php'."\r";
    $layout_model .= '    global $lib;'."\r";
    $layout_model .= '    global $friendlyGuacamole;'."\r";
    $layout_model .= '    $layout = $lib->load_json_file(__DIR__.\'/_layout.data.json\');'."\r";
    $layout_model .= '    $friendlyGuacamole->LayoutsModule->register($layout, __DIR__);'."\r";
    $layout_model .= '?>'."\r";

?>