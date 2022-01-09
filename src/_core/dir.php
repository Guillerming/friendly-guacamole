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
            $root = explode('/', __DIR__);
            $root = array_slice($root, 0, -1);
            $root = implode('/', $root).'/';
            // internal
            $this->root = $root;
            $this->home = $this->root;
            $this->core = $this->home.'_core/';
            $this->app = $this->home.'app/';
            $this->contents = $this->app.'contents/';
            $this->data = $this->app.'data/';
            $this->public = $this->home.'public/';
            // external
            $root = explode('/', __DIR__);
            $root = array_slice($root, 0, -2);
            $root = implode('/', $root).'/';
            $this->build = $root.'build/';
            $this->src = $root.'src/';
        }
    }

    $dir = new Dir();


?>