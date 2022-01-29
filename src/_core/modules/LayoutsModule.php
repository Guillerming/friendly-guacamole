<?php

    class LayoutsModule {

        private $layouts_registry;

        private $friendlyGuacamole;
        private $dir;
        private $lib;
        private $layouts_registry_filename = '_layout.register.php';

        function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
            global $lib;
            $this->lib = $lib;
            global $dir;
            $this->dir = $dir;
        }

        public function register( $layout, $path ) {
            $array = array();
            if ( isset($layout['id']) ) {
                $array['id'] = $layout['id'];
            }
            if ( isset($layout['view']) ) {
                $array['view'] = array();
                if ( isset($layout['view']['templates']) ) {
                    $array['view']['templates'] = array();
                    for ( $n = 0; $n < count($layout['view']['templates']); $n++ ) {
                        array_push( $array['view']['templates'], $this->lib->add_trailing_slash($path).$layout['view']['templates'][$n] );
                    }
                }
                if ( isset($layout['view']['styles']) ) {
                    $array['view']['styles'] = array();
                    for ( $n = 0; $n < count($layout['view']['styles']); $n++ ) {
                        array_push( $array['view']['styles'], $this->lib->add_trailing_slash($path).$layout['view']['styles'][$n] );
                    }
                }
                if ( isset($layout['view']['scripts']) ) {
                    $array['view']['scripts'] = array();
                    for ( $n = 0; $n < count($layout['view']['scripts']); $n++ ) {
                        array_push( $array['view']['scripts'], $this->lib->add_trailing_slash($path).$layout['view']['scripts'][$n] );
                    }
                }
            }
            $this->layouts_registry[$layout['id']] = $array;
        }

        // TODO:
        // private function validatePath( ) {
            // when a layout is submitted validate it has/or it
            // doesn't a slash (/) at the beginning of the path
        // }

        public function data( $layout_id = null ) {
            if ( !$layout_id ) {
                return $this->layouts_registry;
            }
            if ( !isset($this->layouts_registry[$layout_id]) ) {
                return false;
            }
            return $this->layouts_registry[$layout_id];
        }

        public function html( $layout_id ) {
            if ( !$layout_id ) {
                return false;
            }
            if ( !isset($this->layouts_registry[$layout_id]) ) {
                return false;
            }
            // Loading layout templates
            $output = '';
            ob_start();
            global $friendlyGuacamole;
            for ( $n = 0; $n < count($this->layouts_registry[$layout_id]['view']['templates']); $n++ ) {
                require($this->layouts_registry[$layout_id]['view']['templates'][$n]);
                $output .= ob_get_contents();
            }
            ob_end_clean();
            // ob_clean();
            // Replacing pointers
            $page_id = $this->friendlyGuacamole->RouterModule->state['controller']['id'];
            $pointers = $this->friendlyGuacamole->RouterModule->state['controller']['layout']['pointers'];
            foreach ( $pointers as $pointer_id => $data ) {
                // Loading templates for current pointer
                $templates_stream = '';
                $templates_stream .= '<'.$this->lib->convert_entity_id_to_wrapper_tagname($page_id, $pointer_id).'>';
                ob_start();
                for ( $i = 0; $i < count($data['templates']); $i++ ) {
                    require($data['templates'][$i]);
                    $templates_stream .= ob_get_contents();
                }
                ob_end_clean();
                // ob_clean();
                $templates_stream .= '</'.$this->lib->convert_entity_id_to_wrapper_tagname($page_id, $pointer_id).'>';
                // Replacing pointers with loaded templates
                $output = str_replace( '{{layout-pointer.'.$pointer_id.'}}', $templates_stream, $output );
            }
            // Preparing layout capsule (wrapper)
            $layout_wrapper  = $friendlyGuacamole->SETTINGS['wrapper']['prefix'];
            $layout_wrapper .= 'lay-';
            $layout_wrapper .= substr(md5(rand(0,9).(new DateTime())->getTimestamp()),0,3);
            // Get scripts
            $layout_scripts = $friendlyGuacamole->ScriptsModule->get($this->lib->convert_entity_id_to_wrapper_tagname($layout_id), $layout_wrapper);
            // Append layout tag wrapper
            $output = str_replace('<body>', '<body>'.'<'.$this->lib->convert_entity_id_to_wrapper_tagname($layout_id).' '.$layout_wrapper.'>', $output);
            $output = str_replace('</body>', $layout_scripts.'</body>'.'</'.$this->lib->convert_entity_id_to_wrapper_tagname($layout_id).'>', $output);
            // Returning html
            return $output;
        }

        // Init

        public function init() {
            $this->layouts_registry = array();
            $this->friendlyGuacamole->ContentsLoaderModule->load($this->layouts_registry_filename);
        }
    }
?>
