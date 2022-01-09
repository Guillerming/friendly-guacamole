<?php

    function scriptLogger( $log ) {
        echo $log."\n";
    }

    function getSettings() {
        global $dir;
        return json_decode(file_get_contents($dir->app.'settings.json'), true);
    }

?>