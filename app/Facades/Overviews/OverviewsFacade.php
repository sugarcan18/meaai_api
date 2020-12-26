<?php 
namespace App\Facades\Overviews;

use Illuminate\Support\Facades\Facade;

class OverviewsFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "App\Facades\Overviews\OverviewsClass";
    }
}