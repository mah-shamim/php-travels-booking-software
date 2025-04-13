<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cartrawler extends MX_Controller {


  function __construct(){
   // $this->session->sess_destroy();
    parent::__construct();


   $this->load->library("Cartrawler_lib");
   $this->load->model("Cartrawler_model");
   $this->load->helper("cartrawler_front");

  $this->data['lang_set'] = $this->session->userdata('set_lang');
 $chk = modules::run('Home/is_main_module_enabled','cartrawler');
   if(!$chk){
       Error_404($this);

   }
     $this->data['phone'] = $this->load->get_var('phone');
         $this->data['contactemail'] = $this->load->get_var('contactemail');

      $defaultlang = pt_get_default_language();
   if(empty($this->data['lang_set'])){

      $this->data['lang_set'] = $defaultlang;
   }

 }

	public function index()
	{
       $pickupDate = $this->input->get('pickupdate');
         $settings =  $this->Settings_model->get_front_settings("cartrawler");

       if(!empty($pickupDate)){
        $pickupDateTime = $this->formatDateTime($_GET['pickupdate'],$_GET['timeDepart']);
        $returnDateTime = $this->formatDateTime($_GET['dropoffdate'],$_GET['timeReturn']);
        unset($_GET['pickupdate']);
        unset($_GET['dropoffdate']);
        unset($_GET['timeReturn']);
        unset($_GET['timeDepart']);

        $_GET['pickupDateTime'] = $pickupDateTime;
        $_GET['returnDateTime'] = $returnDateTime;
        $_GET['currency'] = $settings[0]->currency;
        redirect(base_url().'car?'.http_build_query($_GET));
       }


      //http_build_query($_GET)

       $this->data['startLocation'] = $this->input->get('startlocation');
       $this->data['returnLocation'] = $this->input->get('endlocation');
       $this->data['pickupLocationId'] = $this->input->get('pickupLocationId');
       $this->data['returnLocationId'] = $this->input->get('returnLocationId');


       $pickupDateTime = $this->reverseFormatDateTime($this->input->get('pickupDateTime'));
       $returnDateTime = $this->reverseFormatDateTime($this->input->get('returnDateTime'));

       $this->data['pickupdate'] = $pickupDateTime->date;
       $this->data['pickuptime'] = $pickupDateTime->time;

       $this->data['returndate'] = $returnDateTime->date;
       $this->data['returntime'] = $returnDateTime->time;


      $this->data['timing'] = $this->Cartrawler_lib->timingList();
      $this->data['cartrawlerid'] = $settings[0]->cid;
      $this->data['url'] = $settings[0]->secret;
      $this->setMetaData($settings[0]->header_title);
     $loadheaderfooter = $settings[0]->load_headerfooter;
       $this->lang->load("front",$this->data['lang_set']);
      if(empty($loadheaderfooter)){
        $this->theme->partial('modules/cars/cartrawler/list',$this->data);
      }else{
        $this->theme->view('modules/cars/cartrawler/list',$this->data, $this);
      }

}

public function getLocations(){
  if(empty($this->input->get('term'))) {
    $query = $this->input->post('term');
    $id = $this->input->post('inputid');
  } else {
    $query = $this->input->get('term');
    $id = $this->input->get('inputid');
  }

   $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://phptravels.com.co/api/locations.php?query=' . $query,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
    ));

    $cc = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    
  // $result = json_decode($cc);
  // $response = new stdClass;


  //  $response->data = "";
  // if($result->status == "success"){

  //  $response->data .= "<ul>";
  // foreach($result->locations as $r){
  //   $val = $r->locationCode;
  //   $locname = $r->locationName;
  //   $response->data .= "<li onclick='selectLocationValue(\"$val\", \"$id\", \"$locname\")'>".$r->locationName."</li>";
  // }

  // $response->data .= "</ul>";

  // }
  // echo $response->data;
  $this->output->set_content_type('application/json');
  $this->output->set_output($cc);

}

public function addLocationstoDb(){
// exit("exit called");


//$xml=simplexml_load_file("https://ota.cartrawler.com/cartrawlerota/files/static/ctlocation.EN.xml") or die("Error: Cannot create object");
$xml=simplexml_load_file("uploads/locations.xml") or die("Error: Cannot create object");

$count =0;

foreach($xml->Country as $c){
  $countryname = (string)$c['name'];

  foreach($c as $location){
   if(!$this->addedAlready((string)$location['Id'])){
   $data = array(
      'country_code' => (string)$location['CountryCode'],
      'country_name' => $countryname,
      'loc_name' => (string)$location['Name'],
      'loc_code' => (string)$location['Id'],
      'loc_lat' => (string)$location['Lat'],
      'loc_long' => (string)$location['Lng'],
      'loc_address' => (string)$location['Address']
      );


 $this->db->insert('cartrawler_locations',$data);
 echo $this->db->insert_id()."<br>";
}

  }


}




}

function addedAlready($code){

  $this->db->where('loc_code',$code);
  $num = $this->db->get('cartrawler_locations')->num_rows();
  if($num > 0){
    return TRUE;
  }else{
    return FALSE;
  }

}

function formatDateTime($date, $time){
  date_default_timezone_set('GMT');
  $breakDate = explode("/",$date);
  $day = $breakDate[0];
  $month = $breakDate[1];
  $year = $breakDate[2];
  return $year."-".$month."-".$day."T".$time;
}

function reverseFormatDateTime($datetime){
  date_default_timezone_set('GMT');
  $breakDateTime = explode("T",$datetime);
  $date = explode('-', $breakDateTime[0]);
  $time = $breakDateTime[1];
  $finalDate = sprintf('%s-%s-%s', $date[2],$date[1],$date[0]);
  $result = new stdClass;
  $result->date = $finalDate;
  $result->time = $time;
  return $result;
}



}
