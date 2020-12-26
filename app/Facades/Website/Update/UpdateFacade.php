<?php 
namespace App\Facades\Website\Update;

use Illuminate\Support\Facades\Facade;

class UpdateFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "App\Facades\Website\Update\UpdateClass";
    }
}