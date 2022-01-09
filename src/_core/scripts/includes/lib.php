<?php

    class ScriptsLib {

        function __construct() {}

        public function scriptLogger( $log ) {
            echo $log."\n";
        }
    }

    $scriptsLib = new ScriptsLib;

?>