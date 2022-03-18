<?php

    class ErrorModule {

        private $htmlSample;
        private $consoleLogSample;

        function __construct() {
            $this->htmlSample = '<span style="color:red;">{{message}}</span>';
            $this->consoleLogSample = '<script type="text/javascript">console.error(\'{{message}}\');</script>';
        }

        public function log( $message ) {
            return str_replace('{{message}}', $message, $this->htmlSample.$this->consoleLogSample);
        }
    }

?>