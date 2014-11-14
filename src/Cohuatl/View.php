<?php

namespace Cohuatl;

class View {
    private static $instance;

    private $paths = [];

    public static function getInstance() {
        if( self::$instance == null ) {
            self::$instance = new View();
        }

        return self::$instance;
    }

    private function __construct() {

    }

    public function register($path) {
        $this->paths[] = $path;
    }

    public function get($template, $params = []) {
        foreach( $this->paths as $path ) {
            if(file_exists($path . DIRECTORY_SEPARATOR . $template)) {
                extract($params);

                ob_start();

                include $path . DIRECTORY_SEPARATOR . $template;

                return ob_get_clean();
            }
        }

        throw new \RuntimeException( 'Could not find template: ' . $template );
    }
}
