<?php

    class ScriptsModule {

        private $dir;
        private $scripts;
        private $scripts_model;

        public function __construct() {
            global $dir;
            $this->dir = $dir;
            $this->scripts_model = file_get_contents($dir->core.'models/script.wrapper.model.js');
        }

        private function find( $html_tag ) {
            if ( !$this->scripts ) { $this->init(); }
            if ( !$this->scripts ) { return null; }
            for ( $n = 0; $n < count($this->scripts['user']); $n++ ) {
                if ( $this->scripts['user'][$n]['wrapper'] == $html_tag ) {
                    return $this->scripts['user'][$n]['scripts'];
                }
            }
        }

        private function html( $script_files, $html_tag, $wrapper ) {
            $html = '';
            for ( $n = 0; $n < count($script_files); $n++ ) {
                $contents = file_get_contents($script_files[$n]);
                $html .= $contents;
            }

            $model = $this->scripts_model;
            $model = str_replace('{{wrapper}}', $wrapper, $model);
            $model = str_replace('{{html_tag}}', $html_tag, $model);
            $model = str_replace('{{content}}', $html, $model);

            return '<script type="text/javascript">'.$model.'</script>';
        }

        public function get( $html_tag, $wrapper ) {
            $script_files = $this->find($html_tag);
            return $this->html($script_files, $html_tag, $wrapper);
        }

        // Init

        public function init() {
            if ( !file_exists($this->dir->build.'app/temp.scripts.json') ) { return; }
            $this->scripts = json_decode( file_get_contents($this->dir->build.'app/temp.scripts.json'), true );
        }

    }

?>