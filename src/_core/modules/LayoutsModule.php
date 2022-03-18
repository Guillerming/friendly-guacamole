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
            // Preparing vars
            $layout_tagname = $this->lib->create_wrapper_tagname($layout_id);
            // Preparing layout capsule (wrapper)
            $layout_wrapper = $this->lib->create_wrapper_attr('layout');
            // Get scripts
            $layout_scripts = $this->friendlyGuacamole->ScriptsModule->get($layout_tagname, $layout_wrapper);
            // Loading layout templates
            $output = '';
            ob_start();
            global $friendlyGuacamole;
            foreach ($this->layouts_registry[$layout_id]['view']['templates'] as $template) {
                require($template);
                $output .= ob_get_contents();
            }
            ob_end_clean();
            // Replacing pointers
            $page_id = $this->friendlyGuacamole->RouterModule->state['controller']['id'];
            $pointers = $this->friendlyGuacamole->RouterModule->state['controller']['layout']['pointers'];
            foreach ( $pointers as $pointer_id => $data ) {
                // Preparing vars
                $page_tagname = $this->lib->create_wrapper_tagname($page_id, $pointer_id);
                // Preparing page capsule (wrapper)
                $page_wrapper = $this->lib->create_wrapper_attr('page');
                // Get scripts
                $page_scripts = $this->friendlyGuacamole->ScriptsModule->get($page_tagname, $page_wrapper);
                // Templates stream
                $templates_stream = '';
                $templates_stream .= '<'.$page_tagname.' '.$page_wrapper.'>';
                // Looping through templates for current pointer
                ob_start();
                for ( $i = 0; $i < count($data['templates']); $i++ ) {
                    require($data['templates'][$i]);
                    $templates_stream .= ob_get_contents();
                }
                ob_end_clean();
                $templates_stream .= $page_scripts.'</'.$page_tagname.'>';
                // Replacing pointers with loaded templates
                $output = str_replace( '{{layout-pointer.'.$pointer_id.'}}', $templates_stream, $output );
            }
            // Append layout tag wrapper
            $output = str_replace('<body>', '<body>'.'<'.$layout_tagname.' '.$layout_wrapper.'>', $output);
            $output = str_replace('</body>', $layout_scripts.'</body>'.'</'.$layout_tagname.'>', $output);
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
