<?php  header('Access-Control-Allow-Origin: *');







// This can be removed if you use __autoload() in config.php OR use Modular Extensions



require APPPATH.'modules/Api/libraries/REST_Controller.php';







class Contact extends REST_Controller



{



	function __construct()



    {



        // Construct our parent class



        parent::__construct();

        if(!$this->isValidApiKey){
        $this->response($this->invalidResponse, 400);
        }



    }







    function info_get()



    {







        $info = $this->Settings_model->get_contact_page_details();



        $mapurl = base_url()."home/maps/".$info[0]->contact_lat."/".$info[0]->contact_long."/hotel";



        $infodata = array(



        'map' => $mapurl,



        'contact_email' => $info[0]->contact_email,



        'contact_address' => strip_tags($info[0]->contact_address),



        'contact_country' => $info[0]->contact_country,



        'contact_phone' => $info[0]->contact_phone



        );







        if(!empty($infodata))



        {



           $this->response(array('response' => $infodata), 200); // 200 being the HTTP response code



        }







        else



        {



        $this->response(array('response' => array('error' => 'Contact Details not found')), 400);



        }



    }











     function send_post()



    {



        $this->load->model('Admin/Emails_model');



        $sendto = $this->post('sendto');



        $contactdata = array(



        'contact_name' => $this->post('name'),



        'contact_email' => $this->post('email'),



        'contact_subject' => $this->post('subject'),



        'contact_message' => $this->post('message')



        );











     $res = $this->Emails_model->send_contact_email($sendto,$contactdata);



     $message = array('response' => array('sent' => $res));







        $this->response($message, 200); // 200 being the HTTP response code



    }











     function chkpost_get(){



    $url = base_url()."api/contact/send";



     $fields = array('contact_name' => 'JohnDue ali jan','contact_email' => 'mail@example.com', 'contact_subject' => "this is subject",



     'contact_message' => "This is the message",'sendto' => "sendto@email.com");











//url-ify the data for the POST



foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }



rtrim($fields_string, '&');







 $ch = curl_init();



    $timeout = 3;



    curl_setopt ($ch, CURLOPT_URL, $url);



    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);



    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);



    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);



   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');



   curl_setopt($ch,CURLOPT_POST, count($fields));



   curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);



   curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);



    $rawdata = curl_exec($ch);



    curl_close($ch);



     @$json = json_decode($rawdata);



     echo "<pre>";



     print_r($json);







    }











}
