<?php

    function scriptLogger( $log ) {
        echo $log."\n";
    }

    function getSettings() {
        return json_decode(file_get_contents(APP_DIR.'settings.json'), true);
    }

?>