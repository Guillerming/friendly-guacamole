<?php

    class RouterModule {

        public $routes;

        private $friendlyGuacamole;
        private $lib;

        function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
            global $lib;
            $this->lib = $lib;
        }

        // Private methods

        private function load_route_lang_file( $lang_code ) {
            return json_decode( file_get_contents( $this->friendlyGuacamole->DATA_DIR.'i18n/routes/'.$lang_code.'.json' ), true);
        }

        private function load_routes() {
            // Init routes
            $this->routes = array();
            // Load pages from module
            $pages = $this->friendlyGuacamole->PagesModule->data();
            // Iterate through pages
            foreach ( $pages as $page ) {
                // Skip page if no route is declared
                if ( !$page['route']['id'] ) { continue; }
                // Add route data
                $route = array(
                    'id' => $page['route']['id'],
                    'method' => $page['route']['method'],
                    'controller' => $page['id'],
                    'paths' => array()
                );
                // Append paths
                foreach ( $this->friendlyGuacamole->LanguagesModule->get_languages() as $lang_code => $language_data ) {
                    // Getting routes from translation file in current iteration language
                    $routes_lang_file_data = $this->load_route_lang_file( $lang_code );
                    // Guessing prefix
                    $prefix = '/';
                    if ( $lang_code != $this->friendlyGuacamole->SETTINGS['defaults']['language'] ) {
                        $prefix .= $lang_code;
                    }
                    // Append path
                    $route['paths'][$lang_code] = $this->lib->remove_trailing_slash($prefix.$routes_lang_file_data[$page['route']['id']]);
                }
                // Dump
                $this->routes[$page['route']['id']] = $route;
            }
        }

        // Public methods

        public function init() {
            $this->load_routes();
        }
    }

?>