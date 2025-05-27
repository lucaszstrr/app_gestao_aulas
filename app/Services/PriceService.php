<?php

namespace App\Services;

class PriceService{

    public function calcPrice($validateStudent){
        if($validateStudent['school_year'] == 'fundamental 1'){
            return 90.00;
        }

        if($validateStudent['school_year'] == 'fundamental 2'){
            return 100.00;
        }

        if($validateStudent['school_year'] == 'ensino médio'){
            return 120.00;
        }

        if($validateStudent['school_year'] == 'ensino superior'){
            return 130.00;
        }
    }
    
}