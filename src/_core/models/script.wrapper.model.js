(function() {
    function userFunction($context) {{{content}}}
    fg.scriptLoader.add('{{html_tag}}[{{wrapper}}]', function() {
        userFunction(document.querySelector('{{html_tag}}[{{wrapper}}]'));
    });
})();