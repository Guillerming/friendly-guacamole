<?php

    require_once('modules/ComponentsModule.php');

    class FriendlyGuacamole {

        // Directories
        public $HOME_DIR;
        public $CORE_DIR;
        public $APP_DIR;
        public $PUBLIC_DIR;

        // Modules
        public $Components;

        function __construct() {
            // Directories
            $this->HOME_DIR = str_replace('_core', '', __DIR__);
            $this->CORE_DIR = $this->HOME_DIR.'_core/';
            $this->APP_DIR = $this->HOME_DIR.'app/';
            $this->PUBLIC_DIR = $this->HOME_DIR.'public/';
        }

        private function init_components() {
            // Assign Modules
            $this->Components = new ComponentsModule;
            // Init Modules
            $this->Components->init();
        }

        public function init() {
            $this->init_components();
        }
    }

    $friendlyGuacamole = new FriendlyGuacamole;

?>