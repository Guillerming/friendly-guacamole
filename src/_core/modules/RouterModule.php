<?php

    class RouterModule {

        public $routes;
        public $state;

        private $friendlyGuacamole;
        private $lib;
        private $dir;

        function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
            global $lib;
            $this->lib = $lib;
            global $dir;
            $this->dir = $dir;
        }

        // Private methods

        private function load_route_lang_file( $lang_code ) {
            return json_decode( file_get_contents( $this->dir->data.'i18n/routes/'.$lang_code.'.json' ), true);
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

        private function find_matching_path( $url_path ) {
            // TODO: Err pages, dynamic urls...
            foreach ( $this->routes as $id => $route ) {
                foreach ( $route['paths'] as $lang_code => $path ) {
                    if ( $url_path == $path ) {
                        return array(
                            'route' => $this->routes[$id],
                            'language' => $this->friendlyGuacamole->LanguagesModule->get_language( $lang_code ),
                            'controller' => $this->friendlyGuacamole->PagesModule->data( $route['controller'] )
                        );
                    }
                }
            }
            return false;
        }

        // Public methods

        public function init() {
            $this->load_routes();
            $this->state = $this->find_matching_path( $this->friendlyGuacamole->HttpModule->http['url']['path'] );
        }
    }

?>