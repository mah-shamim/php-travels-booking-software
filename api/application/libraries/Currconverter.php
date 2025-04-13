<?php

class Currconverter {
		public $ci = NULL; //codeigniter instance

		public $symbol;
		public $code;
		public $name;
		public $country;
		public $rate;
		public $defaultRate;
		public $mulcur;

		function __construct(){
				$this->ci = & get_instance();
				$this->mulcur = $this->ci->Settings_model->multiCurrencyStatus();
				$defaultcurr = $this->ci->Settings_model->getDefaultCurrency();
				$this->defaultRate = $defaultcurr['rate'];
				$currencycode = $this->ci->session->userdata('currencycode');
				if(!$this->mulcur || empty($currencycode)){
						$this->code = $defaultcurr['code'];
						$this->symbol = $defaultcurr['symbol'];
						$this->name = $defaultcurr['name'];
						$this->rate = $defaultcurr['rate'];
			        	}else{

            $this->code = $this->ci->session->userdata('currencycode');
						$this->symbol = $this->ci->session->userdata('currencysymbol');
						$this->name = $this->ci->session->userdata('currencyname');
						$this->rate = $this->ci->session->userdata('currencyrate');

			        	}
		}

		function convertPrice($amount,$round = 2){

                $price = $this->rate * $amount;
				return str_replace(".00",'',number_format($price,$round));
		}

		function convertPriceRange($amount,$round = 2){
			    $fprice = (float)str_replace(",","",$amount);

                $price = $fprice / $this->rate;
				return round($price,$round);
		}

        function convertPriceFloat($amount,$round = 2){
             $fprice = (float)str_replace(",","",$amount);
             return round($this->rate * $fprice,$round);
        }

        function removeComma($amount,$round = 2){
             $fprice = (float)str_replace(",","",$amount);
             return round($fprice,$round);
        }

         function addComma($amount,$round = 2){

				return str_replace(".00",'',number_format($amount,$round));
        }

        function getCurrencies(){
            $this->ci->db->where('is_active','Yes');
            return $this->ci->db->get('pt_currencies')->result();

        }

}
