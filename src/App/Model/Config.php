<?php

namespace App\Model;

class Config extends \Cohuatl\Lib\ArrayAccess {
    private $store;

    public function __construct($store) {
        $this->store = $store;

        if($store->hasNext()) {
            $this->accessed = $store->first();
        } else {
            $this->accessed = $store->getDefault();
        }
    }

    public function save() {
        (new \Cohuatl\Store('BlogConfig'))->save($this->accessed);
    }
}
