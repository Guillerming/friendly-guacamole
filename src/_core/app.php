<?php

    require_once('lib.php');

    require_once('modules/ContentsLoaderModule.php');
    require_once('modules/LayoutsModule.php');
    require_once('modules/PagesModule.php');
    require_once('modules/ComponentsModule.php');

    class FriendlyGuacamole {

        // Directories
        public $HOME_DIR;
        public $CORE_DIR;
        public $APP_DIR;
        public $CONTENTS_DIR;
        public $PUBLIC_DIR;

        // Modules
        public $ContentsLoaderModule;
        public $LayoutsModule;
        public $PagesModule;
        public $ComponentsModule;

        function __construct() {
            // Directories
            $this->HOME_DIR = str_replace('_core', '', __DIR__);
            $this->CORE_DIR = $this->HOME_DIR.'_core/';
            $this->APP_DIR = $this->HOME_DIR.'app/';
            $this->CONTENTS_DIR = $this->APP_DIR.'contents/';
            $this->PUBLIC_DIR = $this->HOME_DIR.'public/';
        }

        // Module initiators

        private function init_modules() {
            // Assign Modules
            $this->ContentsLoaderModule = new ContentsLoaderModule();
            $this->LayoutsModule = new LayoutsModule();
            $this->PagesModule = new PagesModule();
            $this->ComponentsModule = new ComponentsModule();
            // Init Modules
            $this->LayoutsModule->init();
            $this->PagesModule->init();
            $this->ComponentsModule->init();
        }

        // Init

        public function init() {
            $this->init_modules();
        }
    }

    $lib = new Lib;
    $friendlyGuacamole = new FriendlyGuacamole;

?>