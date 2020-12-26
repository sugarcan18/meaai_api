<?php 
namespace App\Facades\Website\Affiliate;

use Illuminate\Support\Facades\Facade;

class AffiliateFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "App\Facades\Website\Affiliate\AffiliateClass";
    }
}