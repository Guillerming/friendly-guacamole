<?php

    require_once('lib.php');

    require_once('modules/LanguagesModule.php');
    require_once('modules/ContentsLoaderModule.php');
    require_once('modules/LayoutsModule.php');
    require_once('modules/PagesModule.php');
    require_once('modules/ComponentsModule.php');
    require_once('modules/HttpModule.php');
    require_once('modules/RouterModule.php');
    require_once('modules/RenderModule.php');

    class FriendlyGuacamole {

        // Directories
        public $ROOT_DIR;
        public $BUILD_DIR;
        public $HOME_DIR;
        public $CORE_DIR;
        public $APP_DIR;
        public $CONTENTS_DIR;
        public $DATA_DIR;
        public $PUBLIC_DIR;
        // public $output;

        // Settings
        public $SETTINGS;

        // Modules
        public $LanguagesModule;
        public $ContentsLoaderModule;
        public $LayoutsModule;
        public $PagesModule;
        public $ComponentsModule;
        public $HttpModule;
        public $RouterModule;
        public $RenderModule;

        function __construct() {
            // $this->output = '';
            // Directories
            $this->ROOT_DIR = str_replace('build/_core', '', __DIR__);
            $this->BUILD_DIR = $this->ROOT_DIR.'build/';
            $this->HOME_DIR = $this->ROOT_DIR.'src/';
            $this->CORE_DIR = $this->HOME_DIR.'_core/';
            $this->APP_DIR = $this->HOME_DIR.'app/';
            $this->CONTENTS_DIR = $this->APP_DIR.'contents/';
            $this->DATA_DIR = $this->APP_DIR.'data/';
            $this->PUBLIC_DIR = $this->HOME_DIR.'public/';
        }

        // Settings

        private function load_settings() {
            return json_decode(file_get_contents($this->APP_DIR.'settings.json'), true);
        }

        // Module initiators

        private function init_modules() {
            // Assign Modules
            $this->LanguagesModule = new LanguagesModule();
            $this->ContentsLoaderModule = new ContentsLoaderModule();
            $this->LayoutsModule = new LayoutsModule();
            $this->PagesModule = new PagesModule();
            $this->ComponentsModule = new ComponentsModule();
            $this->HttpModule = new HttpModule();
            $this->RouterModule = new RouterModule();
            $this->RenderModule = new RenderModule();
            // Init Modules
            $this->LanguagesModule->init();
            $this->LayoutsModule->init();
            $this->PagesModule->init();
            $this->ComponentsModule->init();
            $this->HttpModule->init();
            $this->RouterModule->init();
        }

        // Init

        public function init() {
            // Settings
            $this->SETTINGS = $this->load_settings();
            // Modules
            $this->init_modules();
        }
    }

    $lib = new Lib;
    $friendlyGuacamole = new FriendlyGuacamole;

?>