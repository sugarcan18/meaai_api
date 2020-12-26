<?php 
namespace App\Repositories\Website\Email;

use Carbon\Carbon;

use App\tour as Tour;
use App\guest as Guest;


class EmailRepository{
  public function __construct(Tour $Tour, Guest $Guest){
    $this->Tour = $Tour;
		$this->Guest = $Guest;
  }

  public function checkEmailsubScribe($guestinfo){
    $result = \DB::table('guests')
                           ->where('email',array_get($guestinfo,'email'))
                           ->where('created_by','subscribe')
                           ->where('is_active',1)
                           ->get();
           if($result){
               return 'true';
           }else{
               return 'false';
           }
}

public function SaveGuestsubScribe($guestinfo){
     $dateTimeNow = Carbon::now('Asia/Bangkok');
     $dateNow = $dateTimeNow->format('Y-m-d');

     $guest = [
         'fullname'=>'Valued Customer',
         'firstname'=>'Valued',
         'lastname'=>'Customer',
         'email'=>array_get($guestinfo,'email'),
         'created_by'=>'subscribe',
         'created_at'=>$dateTimeNow
];
return $this->Guest->insertGetId($guest);
}
  
}