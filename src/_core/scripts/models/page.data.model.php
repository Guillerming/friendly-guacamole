<?php

    $page_data_model  = '{'."\r";
    $page_data_model .= '    "id": "PAGE_{{PAGE_ID}}",'."\r";
    $page_data_model .= '    "layout": {'."\r";
    $page_data_model .= '        "id": "LAYOUT_ID",'."\r";
    $page_data_model .= '        "pointers": {'."\r";
    $page_data_model .= '            "main": {'."\r";
    $page_data_model .= '                "scripts": ["{{PAGE_NAME}}.js"],'."\r";
    $page_data_model .= '                "styles": ["{{PAGE_NAME}}.scss"],'."\r";
    $page_data_model .= '                "templates": ["{{PAGE_NAME}}.php"]'."\r";
    $page_data_model .= '            }'."\r";
    $page_data_model .= '        }'."\r";
    $page_data_model .= '    },'."\r";
    $page_data_model .= '    "route": {'."\r";
    $page_data_model .= '        "id": "ROUTE_ID",'."\r";
    $page_data_model .= '        "method": "GET"'."\r";
    $page_data_model .= '    }'."\r";
    $page_data_model .= '}'."\r";

?>