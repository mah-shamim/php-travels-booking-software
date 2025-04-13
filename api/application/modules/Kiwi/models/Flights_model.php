<?php

class Flights_model extends CI_Model
{

    public function __construct()
    {  
	
        parent::__construct();
    }

    public function get_menu_status()
    {
        $this->db->select('page_id, slug_status');
        $dataAdapter = $this->db->get_where('pt_cms', array(
            'page_slug' => 'kiwi'
        ));
				
        return $dataAdapter->row();
    }

    public function module_settings()
    {
        $dataAdapter = $this->db->get('pt_flights_settings');
        return $dataAdapter->row();
    }

    public function update_settings($payload)
    {
        $this->db->set('header_title', $payload['header_title']);
        $this->db->where('id', $payload['module_setting_id']);
        $this->db->update('pt_flights_settings');

        $this->db->set('slug_status', $payload['menu_status']);
        $this->db->where('page_id', $payload['page_id']);
        $this->db->update('pt_cms');
    }

    function get_flight_data($id)
    {
        $this->db->select('pt_kiwi_flights_routes_setting.*,pt_kiwi_flights_routes.*');
        $this->db->where('pt_kiwi_flights_routes.setting_id', $id);
        $this->db->join('pt_kiwi_flights_routes', 'pt_kiwi_flights_routes.setting_id = pt_kiwi_flights_routes_setting.id');
        $this->db->order_by("pt_kiwi_flights_routes.type", "desc");
        $result = $this->db->get('pt_kiwi_flights_routes_setting')->result();

        return $result;
    }
	
    
	public function add_flight($payloud)
    {
		$dateform = date('d/m/Y',strtotime($payloud[3]));
		if($payloud[5] == 'return')
		{
	      $dateto = date('d/m/Y',strtotime($payloud[4]));
	      $payloud[5] = 'round';
		}
		else{
		$dateto = date('d/m/Y',strtotime($payloud[3]));	
			}
		$formairport = $payloud[1];
		$toairport = $payloud[2];
		$flight_type = $payloud[5];
		$adults = $payloud[7];
		$children = $payloud[8];
		$infants = $payloud[9];
		
		$cabinval = 'M';
		if($payloud[6]=='economy'){ 
			$cabinval = 'M';
		}else if($payloud[6]=='Business'){
			$cabinval = 'C';
		}else if($payloud[6]=='First'){
			$cabinval = 'F';
		}
	
        $ch = curl_init();
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'apikey:papnER0W9jXrqMtlBAbmck7M2qJPUvRC'
		);
		
		
		if($flight_type == 'round')
		{
		   $url = 'https://tequila-api.kiwi.com/v2/search?fly_from='.$formairport.'&fly_to='.$toairport.'&date_from='.$dateform.'&date_to='.$dateform.'&return_from='.$dateto.'&return_to='.$dateto.'&flight_type='.$flight_type.'&adults='.$adults.'&children='.$children.'&infants='.$infants.'&selected_cabins='.$cabinval;	
			
		}
		else{
		
		$url = 'https://tequila-api.kiwi.com/v2/search?fly_from='.$formairport.'&fly_to='.$toairport.'&date_from='.$dateform.'&date_to='.$dateto.'&flight_type='.$flight_type.'&adults='.$adults.'&children='.$children.'&infants='.$infants.'&selected_cabins='.$cabinval;
	    }
		
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$authToken = curl_exec($ch);
		//return $authToken;
		$getjson = json_decode($authToken);
		
		
		//return $getjson;
		
	
		foreach($getjson->data as $rowsval)
		{
			 
			
				if($payloud[6] == "economy")
				{
					$flighttype = "economy";
					$refundable = "Non Refundable";
				}else{
					$flighttype = "business";
					$refundable = "Refundable";
				}
			
				if($payloud[5] == "round")
				{
					$flightmode = "return";
				}else{
					$flightmode = "oneway";
				}
				
				
				$flightStatus = '';
				$adultprice = $rowsval->fare->adults;
				$childprice = $rowsval->fare->children;
				$infantprice = $rowsval->fare->infants;
				$total_hours_departure = gmdate("H:i",  $rowsval->duration->departure);
				$total_hours_return = gmdate("H:i",  $rowsval->duration->return);
				
				$total_hours_departure_expn =explode(':',$total_hours_departure);
				$total_hours_departure_val =$total_hours_departure_expn[0].'h '.$total_hours_departure_expn[1].'m';
				
				$total_hours_return_expn =explode(':',$total_hours_return);
				$total_hours_return_val =$total_hours_return_expn[0].'h '.$total_hours_return_expn[1].'m';
				
				$desc = 'test description';
				$flighttype = $flighttype;
				$flightmode = $flightmode;
				$refundable = $refundable;
				$locations = $rowsval->cityFrom;
				
				$sarchid = $rowsval->id;
				$bookingtoken = $rowsval->booking_token;
				
				$datesdep = date('Y-m-d',strtotime($rowsval->utc_departure));
				$timesdep = date('H:i:s',strtotime($rowsval->utc_departure));
				
				$datearrival = date('Y-m-d',strtotime($rowsval->utc_arrival));
				$timesarrival = date('H:i:s',strtotime($rowsval->utc_arrival));
				
				$flightnos = $rowsval->route[0]->flight_no;
				$aeroplanes = $rowsval->route[0]->airline;

				$thumbairline = $aeroplanes.'.png';
				
				$queryval = $this->db->query('select * from pt_flights_airlines where thumbnail="'.$thumbairline.'"');
				$rowsairline = $queryval->row();
				
				array_walk($dates, function (&$val, $key) {
					if(!empty($val)) {
						list($day, $month, $year) = explode('/', $val);
						$val = sprintf('%s-%s-%s', $year, $month, $day);
					}
				});
				$from = json_decode(array_shift($locations));
				
				$from_code = $formairport;
				$from_location = $rowsval->cityFrom;

				$arriaval = json_decode(array_pop($locations));
				$to_code = $toairport;
				$to_location = $rowsval->cityTo;
			
				
				$data_insert = array(
					"flight_type" => $flighttype,
					"from_code" => $from_code,
					"to_code" => $to_code,
					"refundable" => $refundable,	
					"flight_mode" => $flightmode,
					"desc_flight" => $desc,
					"deposite" => 60,
					"tax" => 55,
					"flightStatus" => "Enable",
					"total_hours_departure" => $total_hours_departure_val,
					"total_hours_return" => $total_hours_return_val,
					"route_id" => "0",
					);
					
				$this->db->insert('pt_kiwi_flights_routes_setting', $data_insert);
				$sibling_id = $this->db->insert_id();
				
               $allroute =  $rowsval->route;
			 for($i=0;$i<count($allroute);$i++)
			 {
				 $from_code =$allroute[$i]->cityCodeFrom;
				 $to_code =$allroute[$i]->cityCodeTo;
				 $from_location =$allroute[$i]->cityFrom;
				 $to_location =$allroute[$i]->cityTo;
				 
				 $datesdep = date('Y-m-d',strtotime($allroute[$i]->utc_departure));
				 $timesdep = date('H:i:s',strtotime($allroute[$i]->utc_departure));
				 $datearrival = date('Y-m-d',strtotime($allroute[$i]->utc_arrival));
				 $timesarrival = date('H:i:s',strtotime($allroute[$i]->utc_arrival));
				 
				 $flightnos = $allroute[$i]->flight_no;
				 $aeroplanes = $allroute[$i]->airline;
				 
				 

				$thumbairline = $aeroplanes.'.png';
				
				$queryval = $this->db->query('select * from pt_flights_airlines where thumbnail="'.$thumbairline.'"');
				$rowsairline = $queryval->row();
				
				$locations = $rowsval->cityFrom;
				
				$return=$allroute[$i]->return;
				 
				 
				//$sarchid $bookingtoken
				$data = array(
					"from_code" => $from_code,
					"searchid"=>$sarchid,
					"bookingtoken"=>$bookingtoken,
					"from_location" => $from_location,
					"to_code" => $to_code,
					"to_location" => $to_location,
					"infants_price" => $infantprice,
					"child_price" => $childprice,
					"adults_price" => $adultprice,
					"date_departure" => $datesdep,
					"time_departure" => $timesdep,
					"time_arrival" => $timesarrival,
					"date_arrival" => $datearrival,
					"flight_no" => json_encode($flightnos),
					"date_trans" => json_encode([]),
					"time_trans" => json_encode([]),
					"setting_id" => $sibling_id,
					"type" => $flightmode,
					"aero_arrival" => $rowsairline->name,
					"aero_dep" =>  $rowsairline->name,
					"aero_trans" =>json_encode([]),
					"transact" => json_encode($locations),
					"returnval"=>$return,

				);
				$this->db->insert('pt_kiwi_flights_routes', $data);
			 }
						
				
		   
		}
    }

    public function update_flight()
    {
        $flightStatus = $this->input->post('flightstatus');
        $adultprice = $this->input->post('adultprice')[0];
        $childprice = $this->input->post('childprice')[0];
        $infantprice = $this->input->post('infantprice')[0];
        $total_hours = $this->input->post('total_hours');
        $desc = $this->input->post('desc');
        $flighttype = $this->input->post('flighttype');
        $flightmode = $this->input->post('flightmode');
        $refundable = $this->input->post('refundable');
        $locations = $this->input->post('locations_');
        $dates = $this->input->post('date_');
        $times = $this->input->post('times_');
        $flightnos = $this->input->post('flightnos_');
        $aeroplanes = $this->input->post('aeroplanes_');
        dd($infantprice);
        array_walk($dates, function (&$val, $key) {
            if(!empty($val)){
                list($day, $month, $year) = explode('/', $val);
                $val = sprintf('%s-%s-%s', $year, $month, $day);
            }

        });
        $from = json_decode(array_shift($locations));
        $from_code = $from->code;
        $from_location = $from->label;

        $arriaval = json_decode(array_pop($locations));
        $to_code = $arriaval->code;
        $to_location = $arriaval->label;

        $locations_trans = $this->input->post('locations_return[]');
        $dates_return = $this->input->post('date_return');
        $times_return = $this->input->post('times_return');
        $flightnos_return = $this->input->post('flightno_return[]');
        $aeroplanes_return = $this->input->post('aeroplanes_return[]');

        $from_return = json_decode(array_shift($locations_trans));
        $from_code_return = $from_return->code;
        $from_location_return = $from_return->label;

        $arriaval_return = json_decode(array_pop($locations_trans));
        $to_code_return = $arriaval_return->code;
        $to_location_return = $arriaval_return->label;

        array_walk($dates_return, function (&$val, $key) {
            if(!empty($val))
            {
                list($day, $month, $year) = explode('/', $val);
                $val = sprintf('%s-%s-%s', $year, $month, $day);
            }

        });
        $data = array(
            "from_code" => $from_code,
            "from_location" => $from_location,
            "to_code" => $to_code,
            "to_location" => $to_location,
            "infants_price" => $infantprice,
            "child_price" => $childprice,
            "adults_price" => $adultprice,
            "date_departure" => array_shift($dates),
            "time_departure" => array_shift($times),
            "time_arrival" => array_pop($times),
            "date_arrival" => array_pop($dates),
            "flight_no" => json_encode($flightnos),
            "date_trans" => json_encode($dates),
            "time_trans" => json_encode($times),
            "type" => $flightmode,
            "aero_arrival" => array_pop($aeroplanes),
            "aero_dep" => array_shift($aeroplanes),
            "aero_trans" => json_encode($aeroplanes),
            "transact" => json_encode($locations),

        );
        $this->db->where("setting_id",$this->input->post('routeId'));
        $this->db->where_not_in("type","");
        $this->db->update('pt_kiwi_flights_routes', $data);
        $data_insert = array(
            "flight_type" => $flighttype,
            "refundable" => $refundable,
            "flight_mode" => $flightmode,
            "desc_flight" => $desc,
            "deposite" => $this->input->post('deposite'),
            "tax" => $this->input->post('tax'),
            "flightStatus" => $flightStatus,
            "total_hours" => $total_hours,
            "route_id" => "0",);
        $this->db->where("id",$this->input->post('routeId'));
        $this->db->update('pt_kiwi_flights_routes_setting', $data_insert);

        if($flightmode == "return")
        {
            $adultprice_return = $this->input->post('adultprice')[1];
            $childprice_return = $this->input->post('childprice')[1];
            $infantprice_return = $this->input->post('infantprice')[1];
            $data = array(
                "from_code" => $from_code_return,
                "from_location" => $from_location_return,
                "to_code" => $to_code_return,
                "to_location" => $to_location_return,
                "infants_price" => $infantprice_return,
                "child_price" => $childprice_return,
                "adults_price" => $adultprice_return,
                "date_departure" => array_shift($dates_return),
                "time_departure" => array_shift($times_return),
                "flight_no" => json_encode($flightnos_return),
                "date_arrival" => array_pop($dates_return),
                "date_trans" => json_encode($dates_return),
                "time_trans" => json_encode($times_return),
                "time_arrival" => array_pop($times_return),
                "aero_arrival" => array_pop($aeroplanes_return),
                "aero_dep" => array_shift($aeroplanes_return),
                "aero_trans" => json_encode($aeroplanes_return),
                "transact" => json_encode($locations_trans),
            );
            $this->db->where('setting_id',$this->input->post('routeId'));
            $this->db->where('type',"");
            $this->db->update('pt_kiwi_flights_routes', $data);

        }

    }

    function delete_route($id)
    {
        $this->db->where('setting_id', $id);
        $this->db->delete('pt_kiwi_flights_routes');
        $this->db->where('id', $id);
        $this->db->delete('pt_kiwi_flights_routes_setting');


    }
    function delete_route_multi($id)
    {
        $this->db->select('setting_id');
        $this->db->where('id',$id);
        $setting_id = $this->db->get('pt_kiwi_flights_routes')->row()->setting_id;


        $this->db->where('setting_id', $setting_id);
        $this->db->delete('pt_kiwi_flights_routes');
        $this->db->where('id', $setting_id);
        $this->db->delete('pt_kiwi_flights_routes_setting');


    }

    function get_route($payloud, $limit = 0, $offset = 0,$checkTest)
    {
		
        $this->db->select('pt_kiwi_flights_routes.*,pt_flights_airlines.*,pt_kiwi_flights_routes_setting.*');
        $origin = $payloud[1];
        $destination = $payloud[2];
        $departure = $payloud[3];
        $arrival = $payloud[4];
        $triptype = $payloud[5];
        $cabinclass = $payloud[6];
        $carriers = [];
        
        for($i = 13; $i<count($payloud);$i++)
        {
            array_push($carriers,str_replace('-',' ',$payloud[$i]));
        }
        if($checkTest == "false")
        {
            $this->db->where('pt_kiwi_flights_routes_setting.test', 0);

        }
        if(count($carriers)>0)
        {
            $abcd = array_shift($carriers);
            $this->db->group_start();
            $this->db->where('pt_kiwi_flights_routes.aero_dep', $abcd);

            foreach ($carriers as $ca)
            {
                $this->db->or_where('pt_kiwi_flights_routes.aero_dep', $ca);
            }
            $this->db->group_end();
        }


        if($payloud[10] != 1 || $payloud[11] != 1) {
            if ($payloud[10] == 1) {
                $this->db->where('pt_kiwi_flights_routes.transact', "[]");
            }
            if ($payloud[11] == 1) {
                $this->db->where_not_in('pt_kiwi_flights_routes.transact', "[]");
            }
        }
        if($payloud[12] == 1)
        {
            $this->db->where('pt_kiwi_flights_routes_setting.refundable', "Refundable");
        }

        $this->db->join('pt_flights_airlines', 'pt_flights_airlines.name=pt_kiwi_flights_routes.aero_dep');
        $this->db->join('pt_kiwi_flights_routes_setting', 'pt_kiwi_flights_routes_setting.id=pt_kiwi_flights_routes.setting_id');
        $this->db->where_not_in('pt_kiwi_flights_routes_setting.flightstatus', "Disable");

        $this->db->group_start();
        $this->db->where('pt_kiwi_flights_routes.date_departure =', $departure);
        $this->db->where('pt_kiwi_flights_routes.returnval =', 0);
        $this->db->or_where('pt_kiwi_flights_routes.date_departure =', "0000-00-00");
        $this->db->group_end();

        if($triptype != "oneway")
        {
            $this->db->or_group_start();

            $this->db->where('pt_kiwi_flights_routes.date_arrival =', $arrival);
            $this->db->where('pt_kiwi_flights_routes.returnval =', 1);
            $this->db->or_where('pt_kiwi_flights_routes.date_arrival =', "0000-00-00");
            $this->db->group_end();

        }
        $this->db->where('pt_kiwi_flights_routes_setting.flight_type', $cabinclass);
        //$this->db->where('pt_kiwi_flights_routes_setting.insertdatetime > NOW() - INTERVAL 5 MINUTE');
        if($triptype != "oneway")
        {

            $triptype = "oneway";
            $this->db->where_not_in('pt_kiwi_flights_routes.type', $triptype);

            $this->db->group_start();
            $this->db->where('pt_kiwi_flights_routes.from_code', $origin);
            $this->db->where('pt_kiwi_flights_routes.to_code', $destination);
            $this->db->where('pt_kiwi_flights_routes.type', 'return');

            $this->db->or_where('pt_kiwi_flights_routes.from_code', $destination);
            $this->db->where('pt_kiwi_flights_routes.to_code', $origin);
           $this->db->where('pt_kiwi_flights_routes.type', '');
            $this->db->group_end();
            $this->db->group_by('pt_kiwi_flights_routes.setting_id');
            //$this->db->order_by("setting_id,pt_kiwi_flights_routes.type", "desc");
            if (empty($limit)) {
                $result = $this->db->get('pt_kiwi_flights_routes')->result();
            } else {
                $this->db->limit($limit,$offset);
                $result = $this->db->get('pt_kiwi_flights_routes')->result();
            }

        }else{

            $this->db->where('pt_kiwi_flights_routes_setting.from_code', $origin);
            $this->db->where('pt_kiwi_flights_routes_setting.to_code', $destination);
            $this->db->where('pt_kiwi_flights_routes.type', 'oneway');
           
            $this->db->group_by('pt_kiwi_flights_routes.setting_id');
            if (empty($limit)) {
                $result = $this->db->get('pt_kiwi_flights_routes')->result();
            } else {
                $this->db->limit($limit,$offset);
                $result = $this->db->get('pt_kiwi_flights_routes')->result();
            }
        }
        
       
        if(empty($result) && $checkTest == "true")
        {
            //$this->add_demo_flight($payloud);
			$this->add_flight($payloud); 
			
        }
        return $result;
    }
	
    function add_demo_flight($payloud){

        for($i=0;$i<50;$i++)
        {
            if($i%2==0)
            {
                $flighttype = "economy";
                $refundable = "Non Refundable";
            }else{
                $flighttype = "business";
                $refundable = "Refundable";
            }
            if($payloud[5] == "round")
            {
                $flightmode = "return";
            }else{
                $flightmode = "oneway";

            }
            $data_insert = array(
                "flight_type" => $flighttype,
                "refundable" => $refundable,
                "flight_mode" => $flightmode,
                "desc_flight" => "<h4><strong>Airline protected transfers</strong></h4><div>If you miss a transfer and it&#39;s covered by the airline, contact the airline directly.<br />Missed a connection? Depending on their T&amp;Cs, the airline may offer you:&nbsp;<br />&nbsp;</div><ul>	<li>Another flight to your destination</li>	<li>Hotel, food and drinks during long layovers&nbsp;</li>	<li>A refund<br />	&nbsp;</li></ul><p><strong>Contact the airline:</strong></p><ul>	<li>Try to find the airline&rsquo;s check-in counter at the airport</li>	<li>Call them or open a Live Chat session on their website</li>	<li>Have your e-ticket ready &mdash; they may ask you for your <strong>PNR </strong>Number<br />	&nbsp;</li></ul><p><strong>Baggage :</strong></p><ul>	<li>Maximum 35 KG allowed for in plane transfer&nbsp;</li>	<li>the handy baggage should be not more then 15 KG&nbsp;<br />	&nbsp;</li></ul><p>We do&nbsp;not apply to this type of transfer because it&rsquo;s already covered by the airline.&nbsp;</p>",
                "deposite" => ($i+10),
                "tax" => ($i+10),
                "flightStatus" => "Enable",
                "test" => 1,
                "total_hours" => (rand(2,8)),
                "route_id" => "0",);

            $from_location = $this->get_airport_name($payloud[1]);
            $to_location = $this->get_airport_name($payloud[2]);

            $aero_image = $this->get_airlines_radom(rand(1,285));

            for($j=0;$j<30;$j++)
            {

                $aero_image = $this->get_airlines_radom(rand(1,285));
                if(getimagesize(PT_FLIGHTS_AIRLINES.$aero_image->thumbnail))
                {
                    break 1;
                }
            }

            $this->db->insert('pt_kiwi_flights_routes_setting', $data_insert);
            $sibling_id = $this->db->insert_id();
            $data = array(
                "from_code" => $payloud[1],
                "from_location" => $from_location,
                "to_code" => $payloud[2],
                "to_location" => $to_location,
                "infants_price" => ($i+10),
                "child_price" => ($i+15),
                "adults_price" => rand(100,1000),
                "date_departure" => "0000-00-00",
                "time_departure" => mt_rand(0,23).":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT),
                "time_arrival" => mt_rand(0,23).":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT),
                "date_arrival" => "0000-00-00",
                "flight_no" => json_encode([rand(500,1000)."",""]),
                "date_trans" => json_encode([]),
                "time_trans" => json_encode([]),
                "setting_id" => $sibling_id,
                "type" => $flightmode,
                "aero_arrival" => $aero_image->name,
                "aero_dep" => $aero_image->name,
                "aero_trans" => json_encode([]),
                "transact" => json_encode([]),

            );
            $this->db->insert('pt_kiwi_flights_routes', $data);
            $from_location = $this->get_airport_name($payloud[2]);
            $to_location = $this->get_airport_name($payloud[1]);

            if($payloud[5] == "round"){

                for($j=0;$j<30;$j++)
                {
                    $aero_image = $this->get_airlines_radom(rand(1,285));
                    if(getimagesize(PT_FLIGHTS_AIRLINES.$aero_image->thumbnail))
                    {
                        break 1;
                    }
                }
                $data = array(
                    "from_code" => $payloud[2],
                    "from_location" => $from_location,
                    "to_code" => $payloud[1],
                    "to_location" => $to_location,
                    "infants_price" => ($i + 10),
                    "child_price" => ($i + 15),
                    "adults_price" => rand(100,1000),
                    "date_departure" => "0000-00-00",
                    "time_departure" => mt_rand(0, 23) . ":" . str_pad(mt_rand(0, 59), 2, "0", STR_PAD_LEFT),
                    "time_arrival" => mt_rand(0, 23) . ":" . str_pad(mt_rand(0, 59), 2, "0", STR_PAD_LEFT),
                    "date_arrival" => "0000-00-00",
                    "flight_no" => json_encode([rand(500,1000)."",""]),
                    "date_trans" => json_encode([]),
                    "time_trans" => json_encode([]),
                    "setting_id" => $sibling_id,
                    "aero_arrival" => $aero_image->name,
                    "aero_dep" => $aero_image->name,
                    "aero_trans" => json_encode([]),
                    "transact" => json_encode([]),);
                $this->db->insert('pt_kiwi_flights_routes', $data);
            }

        }
    }
	
	
    function getApiRoutes($arrival_date, $departure_date, $type,$form,$to,$cabinclass_a,$checkTest)
    {
        $this->db->select('pt_kiwi_flights_routes.*,pt_flights_airlines.*,pt_kiwi_flights_routes_setting.*');
        $origin = $form;
        $destination = $to;
        $departure = $departure_date;
        $triptype = $type;
        $cabinclass = $cabinclass_a;

        if($checkTest == "false")
        {
            $this->db->where('pt_kiwi_flights_routes_setting.test', 0);

        }

        $this->db->join('pt_flights_airlines', 'pt_flights_airlines.name=pt_kiwi_flights_routes.aero_dep');
        $this->db->join('pt_kiwi_flights_routes_setting', 'pt_kiwi_flights_routes_setting.id=pt_kiwi_flights_routes.setting_id');
        $this->db->where_not_in('pt_kiwi_flights_routes_setting.flightstatus', "Disable");
        $this->db->group_start();
        $this->db->where('pt_kiwi_flights_routes.date_departure =', $departure);
        $this->db->or_where('pt_kiwi_flights_routes.date_departure =', "0000-00-00");
        $this->db->group_end();
        if($triptype != "oneway")
        {
            $this->db->group_start();
            $this->db->where('pt_kiwi_flights_routes.date_arrival =', $arrival_date);
            $this->db->or_where('pt_kiwi_flights_routes.date_arrival =', "0000-00-00");
            $this->db->group_end();

        }
        $this->db->where('pt_kiwi_flights_routes_setting.flight_type', $cabinclass);
        if($triptype != "oneway")
        {

            $triptype = "oneway";
           $this->db->where_not_in('pt_kiwi_flights_routes.type', $triptype);

            $this->db->group_start();
            $this->db->where('pt_kiwi_flights_routes.from_code', $origin);
            $this->db->where('pt_kiwi_flights_routes.to_code', $destination);
            $this->db->where('pt_kiwi_flights_routes.type', 'return');

            $this->db->or_where('pt_kiwi_flights_routes.from_code', $destination);
            $this->db->where('pt_kiwi_flights_routes.to_code', $origin);
            $this->db->where('pt_kiwi_flights_routes.type', '');
            $this->db->group_end();
            $this->db->order_by("setting_id,pt_kiwi_flights_routes.type", "desc");

                $result = $this->db->get('pt_kiwi_flights_routes')->result();


        }else{

            $this->db->where('pt_kiwi_flights_routes.from_code', $origin);
            $this->db->where('pt_kiwi_flights_routes.to_code', $destination);

                $result = $this->db->get('pt_kiwi_flights_routes')->result();

        }
        if(empty($result) && $checkTest == "true")
        {
            $payloud=["",$origin,$to,"","",$type];
            $this->add_demo_flight($payloud);
        }

        return $result;
    }

    function get_route_all($payloud,$checkTest )
    {
        $this->db->select('pt_kiwi_flights_routes.*,pt_flights_airlines.*,pt_kiwi_flights_routes_setting.*');

        $carriers = [];

        if($checkTest == "false")
        {
            $this->db->where('pt_kiwi_flights_routes_setting.test', 0);

        }
        for($i = 13; $i<count($payloud);$i++)
        {
            array_push($carriers,str_replace('-',' ',$payloud[$i]));
        }
        $this->db->group_start();
        $this->db->where('pt_kiwi_flights_routes.date_departure =', date("Y-m-d"));
        $this->db->or_where('pt_kiwi_flights_routes.date_departure =', "0000-00-00");
        $this->db->where('pt_kiwi_flights_routes.type', "oneway");

        $this->db->group_end();
        if(count($carriers)>0)
        {
            $abcd = array_shift($carriers);
            $this->db->group_start();
            $this->db->where('pt_kiwi_flights_routes.aero_dep', $abcd);

            foreach ($carriers as $ca)
            {
                $this->db->or_where('pt_kiwi_flights_routes.aero_dep', $ca);
            }
            $this->db->group_end();
        }


        if($payloud[10] != 1 || $payloud[11] != 1) {
            if ($payloud[10] == 1) {
                $this->db->where('pt_kiwi_flights_routes.transact', "[]");
            }
            if ($payloud[11] == 1) {
                $this->db->where_not_in('pt_kiwi_flights_routes.transact', "[]");
            }
        }
        if($payloud[12] == 1)
        {
            $this->db->where('pt_kiwi_flights_routes_setting.refundable', "Refundable");
        }

        $this->db->join('pt_flights_airlines', 'pt_flights_airlines.name=pt_kiwi_flights_routes.aero_dep');
        $this->db->join('pt_kiwi_flights_routes_setting', 'pt_kiwi_flights_routes_setting.id=pt_kiwi_flights_routes.setting_id');
        $this->db->where_not_in('pt_kiwi_flights_routes_setting.flightstatus', "Disable");
        $this->db->order_by("pt_kiwi_flights_routes.id,setting_id,pt_kiwi_flights_routes.type", "desc");
        $this->db->limit(25);

        $result = $this->db->get('pt_kiwi_flights_routes')->result();





        return $result;
    }

    function get_return_flight($id)
    {
        $this->db->select("pt_kiwi_flights_routes.*");
        $this->db->where('id',$id);
        return $this->db->get('pt_kiwi_flights_routes')->result();

    }
    function get_airport_name($code)
    {
        $this->db->select("pt_flights_airports.*");
        $this->db->where('code',$code);
        return $this->db->get('pt_flights_airports')->row()->name;

    }
    function get_airlines_radom($id)
    {
        $this->db->select("pt_flights_airlines.*");
        $this->db->where('id',$id);
        return $this->db->get('pt_flights_airlines')->row();

    }
    function get_airlines($payloud,$checkTest)
    {
        $this->db->select('pt_kiwi_flights_routes.*,pt_flights_airlines.*,pt_kiwi_flights_routes_setting.*');
        $origin = $payloud[1];
        $destination = $payloud[2];
        $triptype = $payloud[5];
        $cabinclass = $payloud[6];
        $departure = $payloud[3];
        $arrival = $payloud[3];

        if($checkTest == "false")
        {
            $this->db->where('pt_kiwi_flights_routes_setting.test', 0);

        }
        if($payloud[10] != 1 || $payloud[11] != 1) {
            if ($payloud[10] == 1) {
                $this->db->where('pt_kiwi_flights_routes.transact', "[]");
            }
            if ($payloud[11] == 1) {
                $this->db->where_not_in('pt_kiwi_flights_routes.transact', "[]");
            }
        }
        $this->db->group_start();
        $this->db->where('pt_kiwi_flights_routes.date_departure =', $departure);
        $this->db->or_where('pt_kiwi_flights_routes.date_departure =', "0000-00-00");
        $this->db->group_end();

        if($triptype != "oneway")
        {
            $this->db->group_start();

            $this->db->where('pt_kiwi_flights_routes.date_arrival =', $arrival);
            $this->db->or_where('pt_kiwi_flights_routes.date_arrival =', "0000-00-00");
            $this->db->group_end();

        }
        if($payloud[12] == 1)
        {
            $this->db->where('pt_kiwi_flights_routes_setting.refundable', "Refundable");
        }
        $this->db->join('pt_flights_airlines', 'pt_flights_airlines.name=pt_kiwi_flights_routes.aero_dep');
        $this->db->join('pt_kiwi_flights_routes_setting', 'pt_kiwi_flights_routes_setting.id=pt_kiwi_flights_routes.setting_id');
        $this->db->where_not_in('pt_kiwi_flights_routes_setting.flightstatus', "Disable");

        $this->db->where('pt_kiwi_flights_routes_setting.flight_type', $cabinclass);
        if($triptype != "oneway")
        {

            $triptype = "oneway";
            $this->db->where_not_in('pt_kiwi_flights_routes.type', $triptype);
            $this->db->group_start();
            $this->db->where('pt_kiwi_flights_routes.from_code', $origin);
            $this->db->or_where('pt_kiwi_flights_routes.from_code', $destination);
            $this->db->group_end();

            $this->db->group_start();
            $this->db->where('pt_kiwi_flights_routes.to_code', $origin);
            $this->db->or_where('pt_kiwi_flights_routes.to_code', $destination);
            $this->db->group_end();
            $this->db->order_by("setting_id,pt_kiwi_flights_routes.type", "desc");
            $result = $this->db->get('pt_kiwi_flights_routes')->result();
        }else{
            $this->db->where('pt_kiwi_flights_routes.from_code', $origin);
            $this->db->where('pt_kiwi_flights_routes.to_code', $destination);
            $result = $this->db->get('pt_kiwi_flights_routes')->result();
        }
        $final_array = array();
        foreach ($result as $re)
        {
            if(!in_array($re->name,array_column($final_array,"name")))
            {
                $object = (object)["name"=>$re->name,"thumbnail"=>$re->thumbnail];
                array_push($final_array,$object);
            }

        }
        return $final_array;
    }
    function get_airlines_all($payloud,$checkTest)
    {
        $this->db->select('pt_kiwi_flights_routes.*,pt_flights_airlines.*,pt_kiwi_flights_routes_setting.*');


        if($payloud[10] != 1 || $payloud[11] != 1) {
            if ($payloud[10] == 1) {
                $this->db->where('pt_kiwi_flights_routes.transact', "[]");
            }
            if ($payloud[11] == 1) {
                $this->db->where_not_in('pt_kiwi_flights_routes.transact', "[]");
            }
        }
        if($checkTest == "false")
        {
            $this->db->where('pt_kiwi_flights_routes_setting.test', 0);

        }
        if($payloud[12] == 1)
        {
            $this->db->where('pt_kiwi_flights_routes_setting.refundable', "Refundable");
        }
        $this->db->join('pt_flights_airlines', 'pt_flights_airlines.name=pt_kiwi_flights_routes.aero_dep');
        $this->db->join('pt_kiwi_flights_routes_setting', 'pt_kiwi_flights_routes_setting.id=pt_kiwi_flights_routes.setting_id');
        $this->db->where_not_in('pt_kiwi_flights_routes_setting.flightstatus', "Disable");
        $this->db->order_by("pt_kiwi_flights_routes.id,setting_id,pt_kiwi_flights_routes.type", "desc");
        $this->db->limit(25);

        $result = $this->db->get('pt_kiwi_flights_routes')->result();

        $final_array = array();
        foreach ($result as $re)
        {
            if(!in_array($re->name,array_column($final_array,"name")))
            {
                $object = (object)["name"=>$re->name,"thumbnail"=>$re->thumbnail];
                array_push($final_array,$object);
            }

        }
        return $final_array;
    }
    function get_aeroimg($name)
    {
        $this->db->select('pt_flights_airlines.thumbnail');
        $this->db->where('name',$name);
        return $this->db->get('pt_flights_airlines')->row();
    }
    function get_taxdeposite($setting_id)
    {
        $this->db->select('pt_kiwi_flights_routes.*,pt_flights_airlines.*,pt_kiwi_flights_routes_setting.*');
        $this->db->join('pt_kiwi_flights_routes_setting', 'pt_kiwi_flights_routes_setting.id=pt_kiwi_flights_routes.setting_id');
        $this->db->join('pt_flights_airlines', 'pt_flights_airlines.name=pt_kiwi_flights_routes.aero_dep');
        $this->db->where('setting_id',$setting_id);
        $result = $this->db->get('pt_kiwi_flights_routes')->result();
        return $result;
    }
    function get_flights_data($id,$tid){
        $this->db->select('pt_bookings.booking_subitem');
        $this->db->where('booking_id',$id);
        $item = $this->db->get('pt_bookings')->row();
        $item = json_decode($item->booking_subitem);
        if($item->type != "oneway")
        {
            $this->db->select('pt_kiwi_flights_routes.*,pt_flights_airlines.*,pt_kiwi_flights_routes_setting.*');
            $this->db->join('pt_flights_airlines', 'pt_flights_airlines.name=pt_kiwi_flights_routes.aero_dep');
            $this->db->join('pt_kiwi_flights_routes_setting', 'pt_kiwi_flights_routes_setting.id=pt_kiwi_flights_routes.setting_id');
            $this->db->where('pt_kiwi_flights_routes_setting.id',$tid);
        }else{
            $this->db->select('pt_kiwi_flights_routes.*,pt_flights_airlines.*,pt_kiwi_flights_routes_setting.*');
            $this->db->join('pt_flights_airlines', 'pt_flights_airlines.name=pt_kiwi_flights_routes.aero_dep');
            $this->db->join('pt_kiwi_flights_routes_setting', 'pt_kiwi_flights_routes_setting.id=pt_kiwi_flights_routes.setting_id');
            $this->db->where('pt_kiwi_flights_routes_setting.id',$tid);
            $this->db->where('pt_kiwi_flights_routes.from_code',$item->from);
            $this->db->where('pt_kiwi_flights_routes.to_code',$item->to);
        }
        $this->db->order_by("pt_kiwi_flights_routes.type", "desc");
        $passArr = [];
        array_push($passArr,$item);
        array_push($passArr,$this->db->get('pt_kiwi_flights_routes')->result());
        return  $passArr;
    }

}
