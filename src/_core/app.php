<?php

    require_once('lib.php');

    require_once('modules/ErrorModule.php');

    require_once('modules/LanguagesModule.php');
    require_once('modules/ContentsLoaderModule.php');
    require_once('modules/LayoutsModule.php');
    require_once('modules/PagesModule.php');
    require_once('modules/ComponentsModule.php');
    require_once('modules/HttpModule.php');
    require_once('modules/RouterModule.php');
    require_once('modules/RenderModule.php');
    require_once('modules/ScriptsModule.php');
    require_once('modules/VisitorModule.php');

    class FriendlyGuacamole {

        // App
        private $lib;
        private $dir;

        // Settings
        public $SETTINGS;

        // Public Modules
        public $ErrorModule;
        public $LanguagesModule;
        public $ContentsLoaderModule;
        public $LayoutsModule;
        public $PagesModule;
        public $ComponentsModule;
        public $HttpModule;
        public $RouterModule;
        public $RenderModule;
        public $ScriptsModule;
        public $VisitorModule;

        // Constructor
        function __construct() {
            global $lib;
            $this->lib = $lib;
            global $dir;
            $this->dir = $dir;
        }

        /*
         * Settings
         */

        private function load_settings() {
            return json_decode(file_get_contents($this->dir->app.'settings.json'), true);
        }

        /*
         * Module initiators
         * 
         * It executes all modules initiators
         */

        private function init_modules() {
            // Assign Modules
            $this->ErrorModule = new ErrorModule();
            $this->LanguagesModule = new LanguagesModule();
            $this->ContentsLoaderModule = new ContentsLoaderModule();
            $this->LayoutsModule = new LayoutsModule();
            $this->PagesModule = new PagesModule();
            $this->ComponentsModule = new ComponentsModule();
            $this->HttpModule = new HttpModule();
            $this->RouterModule = new RouterModule();
            $this->RenderModule = new RenderModule();
            $this->ScriptsModule = new ScriptsModule();
            $this->VisitorModule = new VisitorModule();
            // Init Public Modules
            $this->LanguagesModule->init();
            $this->LayoutsModule->init();
            $this->PagesModule->init();
            $this->ComponentsModule->init();
            $this->HttpModule->init();
            $this->RouterModule->init();
            $this->ScriptsModule->init();
            $this->VisitorModule->init();
        }

        /*
         * App Init
         * 
         * Starts the app
         */

        public function init() {
            // Settings
            $this->SETTINGS = $this->load_settings();
            // Modules
            $this->init_modules();
        }


        /*
         * Component HTML getter
         * 
         * This is meant to enable a shorter way to load
         * components' html
         */

        public function html( $id ) {
            return $this->ComponentsModule->html($id);
        }
    }

    $lib = new Lib;
    $friendlyGuacamole = new FriendlyGuacamole;
    // Alias
    $fg = $friendlyGuacamole;

?>