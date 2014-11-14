<?php

namespace Cohuatl;

class Router
{
    private $filter;

    private $config;

    private $user;

    private $routes = array();

    public function __construct( $config, $filter, $user )
    {
        $this->config = $config;
        $this->filter = $filter;
        $this->user = $user;
    }

    public function route( $uri )
    {
        $uri = $this->cleanGetParams( $uri );

        $route = $this->match( $uri );

        if( $route === null ) {
            throw new \InvalidArgumentException( 'Unable to determine route.' );
        }

        $this->call( $route['method'], $route['captures'] );
    }

    public function addRoute( $route, callable $method )
    {
        $route_regex = $this->decomposeRoute( $route );

        $this->routes[ $route_regex ] = $method;
    }

    private function call( $method, $params ) {
        $method( $params, $this->config, $this->filter, $this->user );
    }

    private function decomposeRoute( $route )
    {
        $match = '/^\/$/';

        if ( $route != '/' ) {
            $chunks = explode( '/', $route );

            $match = '/^';

            foreach( $chunks as $chunk ) {
                if( $chunk === '' ) {
                    continue;
                }

                $match .= '\/';

                if( $chunk[0] === ':' ) {
                    $capture = substr( $chunk, 1 );

                    $match .= '(?P<' . $capture . '>[^\/]+)';
                } else {
                    $match .= $chunk;
                }
            }

            $match .= '$/';
        }

        return $match;
    }

    private function match( $route )
    {
        foreach( $this->routes as $pattern => $method ) {
            if( $this->pregMatchCapture( $pattern, $route, $captures ) ) {
                return array(
                    'method' => $method,
                    'captures' => $captures
                );
            }
        }

        return null;
    }

    private function pregMatchCapture( $pattern, $route, &$captures) {
        $match = preg_match( $pattern, $route, $captures );

        if( $match === 0 ) {
            return 0;
        }

        foreach ( $captures as $key => $capture ) {
            if( is_int( $key ) ) {
                unset( $captures[$key] );
            }
        }

        return 1;
    }

    private function cleanGetParams( $uri ) {
        $pos_inter = strpos( $uri, '?' );

        if( $pos_inter === false ) {
            return $uri;
        } else {
            return substr( $uri, 0, $pos_inter );
        }
    }
}
