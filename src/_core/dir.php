<?php

    class Dir {
        public $root;
        public $build;
        public $home;
        public $core;
        public $app;
        public $contents;
        public $data;
        public $public;

        function __construct() {
            $this->root = __DIR__.'/../';
            $this->home = $this->root;
            $this->core = $this->home.'_core/';
            $this->app = $this->home.'app/';
            $this->contents = $this->app.'contents/';
            $this->data = $this->app.'data/';
            $this->public = $this->home.'public/';
            // external
            $this->build = $this->root.'../build/';
        }
    }

    $dir = new Dir();


?>