<?php

    class LanguagesModule {

        private $dir;
        private $languages;
        private $friendlyGuacamole;

        private $languages_index_json_path;

        public function __construct() {
            global $dir;
            $this->dir = $dir;
            $this->languages_index_json_path = $this->dir->data.'languages.json';
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
        }

        // Private methods

        private function load_languages() {
            $languages = json_decode(file_get_contents($this->languages_index_json_path), true);
            foreach ( $languages as $lang_code => $language_data ) {
                if ( !$language_data['enabled'] ) { continue; }
                $this->languages[$lang_code] = $language_data;
            }
        }

        // Public methods

        public function init() {
            $this->languages = [];
            $this->load_languages();
        }

        public function get_default_lang() {
            return $this->friendlyGuacamole->SETTINGS['defaults']['language'];
        }

        public function get_language( $lang_code ) {
            if ( !isset($this->languages[$lang_code]) ) {
                return [];
            }
            return $this->languages[$lang_code];
        }

        public function get_languages() {
            return $this->languages;
        }

        public function is_supported( $language ) {
            if ( gettype($language) == 'array' ) {
                if ( isset($language['lang_code']) ) { $language = $language['lang_code']; }
                if ( isset($language['name']) ) { $language = $language['name']; }
                if ( isset($language['slug']) ) { $language = $language['slug']; }
            }
            if ( gettype($language) != 'string' ) { return false; }
            $language = strtolower($language);
            foreach ( $this->languages as $lang_data ) {
                if (
                    $language == strtolower($lang_data['lang_code'])
                    || $language == strtolower($lang_data['name'])
                    || $language == strtolower($lang_data['slug'])
                ) {
                    if ( $lang_data['enabled'] ) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            return false;
        }
    }

?>