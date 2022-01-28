<?php

    $js_wrapper_model  = '(function(capsuleId) {';
    $js_wrapper_model .= '    var selector = \'{{tagName}}[{{capsuleId}}]\';';
    $js_wrapper_model .= '    var $context = document.querySelector(selector);';
    $js_wrapper_model .= '    fg.scriptLoader.add(selector, function($context) {';
    $js_wrapper_model .= '        {{content}}';
    $js_wrapper_model .= '    });';
    $js_wrapper_model .= '})({{capsuleId}});';

?>