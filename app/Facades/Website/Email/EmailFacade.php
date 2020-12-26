<?php 
namespace App\Facades\Website\Email;

use Illuminate\Support\Facades\Facade;

class EmailFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "App\Facades\Website\Email\EmailClass";
    }
}