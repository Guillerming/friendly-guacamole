<?php

    class LanguagesModule {

        private $languages;

        private $languages_index_json_path;

        public function __construct() {
            global $friendlyGuacamole;
            $this->languages_index_json_path = $friendlyGuacamole->DATA_DIR.'languages.json';
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

        public function get_language( $lang_code ) {
            if ( !isset($this->languages[$lang_code]) ) {
                return [];
            }
            return $this->languages[$lang_code];
        }

        public function get_languages() {
            return $this->languages;
        }
    }

?>