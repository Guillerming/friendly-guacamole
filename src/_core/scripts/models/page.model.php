<?php

    $page_model  = '<?php'."\r";
    $page_model .= '    global $lib;'."\r";
    $page_model .= '    global $friendlyGuacamole;'."\r";
    $page_model .= '    $page = $lib->load_json_file(__DIR__.\'/_page.data.json\');'."\r";
    $page_model .= '    $friendlyGuacamole->PagesModule->register($page, __DIR__);'."\r";
    $page_model .= '?>'."\r";

?>