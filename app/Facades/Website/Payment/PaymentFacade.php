<?php 
namespace App\Facades\Website\Payment;

use Illuminate\Support\Facades\Facade;

class PaymentFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "App\Facades\Website\Payment\PaymentClass";
    }
}