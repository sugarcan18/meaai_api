<?php 
namespace App\Facades\Admin;

use Illuminate\Support\Facades\Facade;

class AdminFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "App\Facades\Admin\AdminClass";
    }
}