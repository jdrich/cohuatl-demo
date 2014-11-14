<?php

namespace App\Auth;

class Auth {
    public function route( $params, $config, $filter, $user ) {
        $action = $params['action'];

        $this->$action( $params, $config, $filter, $user );
    }

    private function login( $params, $config, $filter, $user ) {
        if( $user['cohuatl.logged_in'] ) {
            header('Location: /');
            exit();
        }

        if( !$filter->has('post', 'submit')) {
            $this->loginForm($filter);

            return;
        }

        $username = $filter->get('post', 'username');
        $password = $filter->get('post', 'password');

        $store = new \Cohuatl\Store('User');

        $invalid = false;

        while($store->hasNext() && !$invalid) {
            $check_user = $store->next();

            if($check_user['username'] == $username) {
                if(password_verify($password, $check_user['hash'])) {
                    $user['cohuatl.logged_in'] = true;
                    $user['cohuatl.is_admin'] = $check_user['is_admin'];

                    header('Location: /');
                    exit();
                }
            }
        }

        echo 'Invalid login.';
    }

    private function logout( $params, $config, $filter, $user ) {
        $user['cohuatl.logged_in'] = false;
        $user['cohuatl.is_admin'] = false;

        header('Location: /auth/login');
        exit();
    }

    private function loginForm($filter) {
        include 'views/login.php';
    }
}
