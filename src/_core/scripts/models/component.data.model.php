<?php

    $component_data_model  = '{'."\r";
    $component_data_model .= '    "id": "COMPONENT_{{COMPONENT_ID}}",'."\r";
    $component_data_model .= '    "view": {'."\r";
    $component_data_model .= '        "scripts": ["{{COMPONENT_NAME}}.js"],'."\r";
    $component_data_model .= '        "styles": ["{{COMPONENT_NAME}}.scss"],'."\r";
    $component_data_model .= '        "templates": ["{{COMPONENT_NAME}}.php"]'."\r";
    $component_data_model .= '    }'."\r";
    $component_data_model .= '}'."\r";

?>