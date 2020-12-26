<?php 
namespace App\Facades\Users;

use Illuminate\Support\Facades\Facade;

class UsersFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "App\Facades\Users\UsersClass";
    }
}