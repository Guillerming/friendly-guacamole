<?php

    $layout_data_model  = '{'."\r";
    $layout_data_model .= '    "id": "LAYOUT_{{LAYOUT_ID}}",'."\r";
    $layout_data_model .= '    "view": {'."\r";
    $layout_data_model .= '        "scripts": ["{{LAYOUT_NAME}}.js"],'."\r";
    $layout_data_model .= '        "styles": ["{{LAYOUT_NAME}}.scss"],'."\r";
    $layout_data_model .= '        "templates": ["{{LAYOUT_NAME}}.php"]'."\r";
    $layout_data_model .= '    }'."\r";
    $layout_data_model .= '}'."\r";

?>