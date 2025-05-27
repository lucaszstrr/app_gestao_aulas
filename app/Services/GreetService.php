<?php

namespace App\Services;
use Carbon\Carbon;

class GreetService{

    public function greet(){
        $time = Carbon::now('America/Sao_Paulo')->format('H:i:s');

        if($time >= '12:00:00' && $time <= '17:59:59'){
            return "Boa tarde";
        }elseif($time >= '00:00:00' && $time <= '11:59:59'){
            return "Bom dia";
        }elseif($time >= '18:00:00' && $time <= '23:59:59'){
            return "Boa noite";
        }
    }

}