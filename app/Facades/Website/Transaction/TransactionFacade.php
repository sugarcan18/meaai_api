<?php 
namespace App\Facades\Website\Transaction;

use Illuminate\Support\Facades\Facade;

class TransactionFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "App\Facades\Website\Transaction\TransactionClass";
    }
}