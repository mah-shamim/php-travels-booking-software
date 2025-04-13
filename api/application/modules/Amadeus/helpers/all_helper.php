<?php

    if(!function_exists("calculate_commission")){
        function calculate_commission($amount,$commission_pecentage){
            $amount = ($amount*($commission_pecentage/100))+$amount;
            return $amount;
        }
    }

    if(!function_exists("clean")){
        function clean($string){
            $string = htmlspecialchars($string);
            $string = trim($string);
            $string = strip_tags($string);
            return $string;
        }    
    }