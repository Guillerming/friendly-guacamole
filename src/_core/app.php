<?php

    require_once('modules/ComponentsModule.php');

    class FriendlyGuacamole {

        // Directories
        public $HOME_DIR;
        public $CORE_DIR;
        public $APP_DIR;
        public $CODE_DIR;
        public $PUBLIC_DIR;

        // Modules
        public $ComponentsModule;

        function __construct() {
            // Directories
            $this->HOME_DIR = str_replace('_core', '', __DIR__);
            $this->CORE_DIR = $this->HOME_DIR.'_core/';
            $this->APP_DIR = $this->HOME_DIR.'app/';
            $this->CODE_DIR = $this->APP_DIR.'code/';
            $this->PUBLIC_DIR = $this->HOME_DIR.'public/';
        }

        private function init_components_module() {
            // Assign Modules
            $this->ComponentsModule = new ComponentsModule();
            // Init Modules
            $this->ComponentsModule->init();
        }

        public function init() {
            $this->init_components_module();
        }
    }

    $friendlyGuacamole = new FriendlyGuacamole;

?>