<?php 
namespace App\Facades\Website\Bookings;

use Illuminate\Support\Facades\Facade;

class BookingFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "App\Facades\Website\Bookings\BookingClass";
    }
}