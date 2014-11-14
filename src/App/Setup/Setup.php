<?php

namespace App\Setup;

class Setup extends \App\Controller {
    public function __construct( $params, $config, $filter, $user ) {
        parent::__construct( $params, $config, $filter, $user );

        \Cohuatl\View::getInstance()->register(__DIR__);
    }

    public function index() {
        $config = $this->getConfig();

        // If we have no valid config, we are setting up the site for the first time.
        if($config['default'] || $this->checkAuth()) {
            echo $this->wrapLayout($this->getView('views/setup.php', ['config' => $config]));
        } else {
            echo $this->getUnauthorized();
        }
    }

    public function save() {
        $config = $this->getConfig();

        if(!$config['default'] && !$this->checkAuth()) {
            echo $this->getUnauthorized();

            return;
        }

        $created = false;

        if($config['default']) {
            $this->createInitialUser($config);

            $created = true;
        }

        foreach($config as $key => $value) {
            $new_value = $this->filter->get('post', 'config/' . $key);

            if($value != $new_value) {
                $config[$key] = $new_value;
            }
        }

        $config->save();

        if( $created ) {
            $this->redirect('@login');
        } else {
            echo $this->wrapLayout($this->getView('views/setup.php', ['config' => $config]));
        }
    }

    private function createInitialUser($config) {
        $username = $this->filter->get('post', 'username');
        $password = $this->filter->get('post', 'password');
        $confirm = $this->filter->get('post', 'confirm');

        if($confirm !== $password) {
            throw new \RuntimeException('Provided passwords do not match.');
        }

        $user = (new \Cohuatl\Store('User'))->getDefault();

        $user['username'] = $username;
        $user['hash'] = password_hash(
            $password,
            \PASSWORD_BCRYPT,
            [ 'cost' => $config['user_password_strength'] ]
        );
        $user['is_admin'] = true;

        (new \Cohuatl\Store('User'))->create($user);
    }

    private function checkAuth() {
        return $this->user['cohuatl.logged_in'] && $this->user['cohuatl.is_admin'];
    }

    private function getUnauthorized() {
        return $this->wrapLayout($this->getView('views/unauthorized.php'));
    }

    private function getConfig() {
        return new \App\Model\Config(new \Cohuatl\Store('BlogConfig'));
    }
}
