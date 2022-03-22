<?php

    class VisitorModule {

        private $friendlyGuacamole;

        public function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
        }

        // Private methods

        private function get_priority_matching_supported_lang( $supported_languages ) {
            // Based on https://www.dyeager.org/post/getting-browser-default-language-in-php.html
            if ( !$supported_languages || !strlen($supported_languages) ) { return false; }
            $supported_languages_array = [];
            // Split possible languages into array
            $supported_languages = explode(',', $supported_languages);
            foreach ($supported_languages as $supported_language) {
                // Check for q-value and create associative array. No q-value means 1 by rule
                if ( preg_match("/(.*);q=([0-1]{0,1}.\d{0,4})/i", $supported_language, $matches ) ) {
                    $supported_languages_array[$matches[1]] = (float)$matches[2];
                } else {
                    $supported_languages_array[$supported_language] = 1.0;
                }
            }

            // Return default language (highest q-value)
            $highest_qval = 0.0;
            $priority_lang = null;
            foreach ($supported_languages_array as $supported_language_code => $value) {
                // Skipping if language is not supported
                if ( !$this->friendlyGuacamole->LanguagesModule->is_supported($supported_language_code) ) { continue; }
                if ( $value > $highest_qval ) {
                    $highest_qval = (float)$value;
                    $priority_lang = $supported_language_code;
                }
            }

            return $priority_lang;
        }

        private function get_language_from_url() {
            // TODO: Guessing url by analyzing the requested url
            return false;
        }

        private function get_language_from_cookie() {
            // TODO: Guessing the language from the cookie, if set
            return false;
        }

        private function get_language_from_browser_info() {
            $supported_languages = $this->friendlyGuacamole->HttpModule->http['headers']['supported_languages'];
            $supported_language_code = $this->get_priority_matching_supported_lang($supported_languages);

            return $this->friendlyGuacamole->LanguagesModule->get_language($supported_language_code);
        }


        // Public methods

        public function init() {
        }

        public function get_lang() {
            $url = $this->get_language_from_url();
            $cookie = $this->get_language_from_cookie();
            $browser = $this->get_language_from_browser_info();
            if ( $url ) { return $url; }
            else if ( $cookie ) { return $cookie; }
            else if ( $browser ) { return $browser; }
            else { return $this->friendlyGuacamole->LanguagesModule->get_default_lang(); }

        }
    }

?>