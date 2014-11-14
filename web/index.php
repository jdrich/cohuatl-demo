<?php

if (preg_match('/\.(png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])) {
    return false;
}

require_once '../autoload.php';

session_start();

$session_save = function( $session ) {
    $_SESSION = $session;
};

$request_uri = $_SERVER['REQUEST_URI'];

$supers = array( 'GET', 'POST', 'FILES', 'SERVER' );

foreach( $supers as $super ) {
    $var = strtolower( $super );
    $global = '_' . $super;

    $$var = $GLOBALS[$global];

    unset( $GLOBALS[$global] );
}

try {
    $router = new Cohuatl\Router(
        new Cohuatl\Config(file_get_contents('../config.json')),
        new Cohuatl\Filter($get, $post, $files, $server),
        new Cohuatl\User($_SESSION, $session_save)
    );

    foreach( new App\Routes() as $route => $method ) {
        $router->addRoute( $route, $method );
    }

    $router->route($request_uri);
} catch (Exception $e) {
    echo get_class($e) . ': ' . $e->getMessage();
}
