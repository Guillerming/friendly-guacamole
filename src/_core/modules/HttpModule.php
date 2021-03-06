<?php

    class HttpModule {

        private $lib;
        public $http;

        public function __construct() {
            global $lib;
            $this->lib = $lib;
            $this->http = array();
        }

        // Private methods

        private function sanitize( $property ) {
            return $property;
            return filter_var( $property, FILTER_SANITIZE_ENCODED );
        }

        private function server( $var ) {
            $var = strtoupper($var);
            if ( !isset($_SERVER["$var"]) ) { return ''; }
            return $this->sanitize( $_SERVER["$var"] );
        }

        private function get_path() {
            $path = $this->server('REQUEST_URI');
            $pos = strpos($path, '?');
            if ($pos !== false) {
                $path = substr($path, 0, $pos);
            }
            return $this->lib->remove_trailing_slash( $path );
        }

        private function get_search() {
            $query = $this->server('QUERY_STRING');
            $pos = strpos($query, '&');
            if ($pos !== false) {
                $query = substr($query, $pos + 1, strlen($query) );
            }
            return $query ? '?'.$query : null;
        }

        private function get_params() {
            $search = $this->get_search();
            if (!$search) { return []; }
            $search = str_replace('?', '', $search);
            if ( !strlen($search) ) { return null; }
            $output = [];
            $params = explode('&', $search);
            for ( $n = 0; $n < count($params); $n++ ) {
                $param = explode('=', $params[$n]);
                $output[$param[0]] = $param[1];
            }
            return $output;
        }

        // Public methods

        private function gatherHttpData() {

            $this->http = [
                'url' => [
                    'path' => $this->get_path(),
                    'search' => $this->get_search(),
                    'params' => $this->get_params(),
                    'protocol' => $this->server('SERVER_PROTOCOL'),
                    'host' => $this->server('HTTP_HOST'),
                    'port' => $this->server('SERVER_PORT'),
                ],
                'headers' => [
                    'method' => $this->server('REQUEST_METHOD'),
                    'supported_languages' => $this->server('HTTP_ACCEPT_LANGUAGE'),
                ]
            ];

        }


        // Init
        public function init() {
            $this->gatherHttpData();
        }
    }

?>