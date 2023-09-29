<?php

namespace core;

class Hash{

    public static function create($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verify($password, $hash){
        return password_verify($password, $hash);
    }

}