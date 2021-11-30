<?php

    class RenderModule {

        private $friendlyGuacamole;

        public function __construct() {
            global $friendlyGuacamole;
            $this->friendlyGuacamole = $friendlyGuacamole;
        }

        public function render() {
            $layout_id = $this->friendlyGuacamole->RouterModule->state['controller']['layout']['id'];
            return $this->friendlyGuacamole->LayoutsModule->html( $layout_id );
        }
    }

?>