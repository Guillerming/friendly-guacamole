(function() {
    fg.scriptLoader.add('{{html_tag}}[{{wrapper}}]', function() {
        var $context = document.querySelector('{{html_tag}}[{{wrapper}}]');
        {{content}}
    });
})();