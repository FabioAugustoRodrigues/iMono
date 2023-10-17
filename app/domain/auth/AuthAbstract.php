<?php

namespace app\domain\auth;

use app\domain\model\ModelAbstract;

abstract class AuthAbstract{
    
    public function __construct(){
        $this->removeAuths();
    }

    public function removeAuths(){
        
    }

    abstract function create(ModelAbstract $modelAbstract): bool;
    abstract function check(): bool;

}