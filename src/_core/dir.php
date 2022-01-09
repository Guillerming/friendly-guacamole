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
            // working it out
            $cwd = explode('/', __DIR__);
            $cwd = array_slice($cwd, 0, -1);
            $cwd = implode('/', $cwd).'/';
            // internal
            $this->root = $cwd;
            $this->home = $this->root;
            $this->core = $this->home.'_core/';
            $this->app = $this->home.'app/';
            $this->contents = $this->app.'contents/';
            $this->data = $this->app.'data/';
            $this->public = $this->home.'public/';
            // external
            $this->build = $this->root.'../build/';
            $this->src = $this->root.'../src/';
        }
    }

    $dir = new Dir();


?>