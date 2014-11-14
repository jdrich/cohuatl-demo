<?php

namespace App;

abstract class Controller {
    protected $params;

    protected $config;

    protected $filter;

    protected $user;

    public function __construct( $params, $config, $filter, $user ) {
        $this->params = $params;
        $this->config = $config;
        $this->filter = $filter;
        $this->user = $user;

        \Cohuatl\View::getInstance()->register(__DIR__);
    }

    protected function wrapLayout($content) {
        return $this->getView('views/layout.php', ['content' => $content]);
    }

    protected function getView($view, $params = []) {
        return \Cohuatl\View::getInstance()->get($view, $params);
    }

    protected function redirect( $named_route ) {
        header('Location: ' . (new \App\Routes())->map($named_route));
        exit();
    }
}
