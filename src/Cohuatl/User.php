<?php

namespace Cohuatl;

class User extends Lib\ArrayAccess
{
    private $session_save = null;

    private static $default = array(
        'cohuatl.session' => true,
        'cohuatl.is_admin' => false,
        'cohuatl.logged_in' => false
    );

    public function __construct( array $session, callable $session_save )
    {
        $this->accessed = $session;
        $this->session_save = $session_save;

        $this->setup();
    }

    public function __destruct()
    {
        $save = $this->session_save;

        $save( $this->accessed );
    }

    private function setup()
    {
        if( !isset($this->accessed['cohuatl.session']) ) {
            $this->accessed = array_merge( $this->accessed, self::$default );
        }
    }
}
