<?php

namespace App;

class Routes extends \Cohuatl\Routes
{
    private $named = [
        '@setup_save' => '/setup/save',
        '@login' => '/auth/login'
    ];

    public function __construct() {
        $this->routes['/'] = function ( $params, $config, $filter, $user ) {
            if(!(new \Cohuatl\Store('BlogConfig'))->hasNext()) {
                $this->routes['/setup']($params, $config, $filter, $user);
            } else {
                (new Blog\Blog($params, $config, $filter, $user))->index();
            }
        };

        $this->routes['/setup'] = function ($params, $config, $filter, $user) {
            (new Setup\Setup($params, $config, $filter, $user))->index();
        };

        $this->routes['/setup/save'] = function ($params, $config, $filter, $user) {
            (new Setup\Setup($params, $config, $filter, $user))->save();
        };

        $this->routes['/auth/:action'] = function($params, $config, $filter, $user) {
            (new Auth\Auth())->route($params, $config, $filter, $user);
        };
    }

    public function map($route) {
        if(isset($this->named[$route])) {
            return $this->named[$route];
        }

        throw new \RuntimeException( 'Unknown route: ' . $route );
    }
}
