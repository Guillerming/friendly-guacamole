function ScriptLoader() {

    var SCRIPTS = [];

    function add( selector, callback ) {
        if ( !selector || !callback ) { return; }
        if ( typeof selector != 'string' ) { return; }
        if ( typeof callback != 'function' ) { return; }
        SCRIPTS.push({
            selector: selector,
            callback: callback
        });
    }

    function run() {
        for ( var n = 0; n < SCRIPTS.length; n++ ) {
            if ( document.querySelector(SCRIPTS[n].selector) ) {
                SCRIPTS[n].callback();
            }
        }
    }

    return {
        add: add,
        run: run
    }
}

fg.scriptLoader = ScriptLoader();