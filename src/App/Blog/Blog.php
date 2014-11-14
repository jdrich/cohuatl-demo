<?php

namespace App\Blog;

class Blog
{
    private $config = null;


    public function __construct() {
        \Cohuatl\View::getInstance()->register(__DIR__);

        $this->getConfig();
    }

    public function index() {
        $posts = [];
        $blog = new \Cohuatl\Store( 'Blog' );
        $blog->last();

        $count = 0;
        $on_index = $this->getConfig()['on_index'];

        while( $count < $on_index ) {
            $posts[] = $blog->current();

            $blog->prev();
            $count++;
        }

        $this->wrap(\Cohuatl\View::getInstance()->get('views/index.php', ['posts' => $posts]));
    }

    public function create() {
        $this->wrap(\Cohuatl\View::getInstance()->get('views/create.php'));
    }

    public function save() {

    }

    private function getConfig() {
        if( $this->config == null) {
            $this->config = (new \Cohuatl\Store( 'BlogConfig' ))->next();
        }

        return $this->config;
    }

    private function wrap($content) {
        echo \Cohuatl\View::getInstance()->get('views/layout.php', ['content' => $content]);
    }
}
