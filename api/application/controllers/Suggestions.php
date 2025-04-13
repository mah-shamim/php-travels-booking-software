<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'modules/Travelport_flight/libraries/travelport/ReferenceData.php';
/**
 * Suggestions controller
 *
 * This controller gives suggessions based on query used in search forms for autocomplete.
 */
class Suggestions extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->output->set_content_type('application/json');
    }

    public function airports($filtertype = NULL)
    {
        $query = $this->input->get('q');

        $locres = $this->db->query("SELECT code,name
        FROM pt_flights_airports
         WHERE (code LIKE '%$query%' OR name LIKE '%$query%')
        ORDER BY CASE
       WHEN (code LIKE '%$query%' AND name LIKE '%$query%') THEN 1
        WHEN (code LIKE '%$query%' AND name NOT LIKE '%$query%') THEN 2
         ELSE 3
         END, code")->result();

        if (!empty($locres)) {
            if($filtertype == 'tport') {
                foreach ($locres as $l) {
                    $locations[] = (object) array('id' => $l->code, 'text' => $l->name." (".$l->code.")");
                }
            } else {
                foreach ($locres as $l) {
                    $locations[] = (object) array('id' => json_encode(["code" =>$l->code,"label" => $l->name]), 'text' => $l->name." (".$l->code.")");
                }
            }
            $results = json_encode($locations);
        }else{
            $results = json_encode(array("text" => "Not Found"));
        }
        $this->output->set_output($results);
    }


    public function juniper_cities()
    {
        $this->dbhb = getDatabaseConnection('juniper');

        $query = $this->input->get('q');

//        $locres = $this->db->query("SELECT city_name, city_code, country_name FROM pt_ejuniper_cities
//         WHERE (city_name LIKE '%$query%' OR city_code LIKE '%$query%' OR country_name LIKE '%$query%'  )
//        ORDER BY CASE
//       WHEN (city_name LIKE '%$query%' AND city_code LIKE '%$query%') THEN 1
//        WHEN (city_name LIKE '%$query%' AND city_code NOT LIKE '%$query%') THEN 2
//         ELSE 3
//         END, city_name")->result();
        $locres = $this->dbhb->query("SELECT *
FROM `pt_juniper_zonelist`
WHERE `Name` LIKE '%$query%'")->result();

        if (!empty($locres)) {
            foreach ($locres as $l) {
                $locations[] = (object) array('id' => str_replace(' ','-',$l->Name), 'text' => $l->Name." (".$l->AreaType.")");
            }
            $results = json_encode($locations);
        }else{
            $results = json_encode(array("text" => "Not Found"));
        }
        $this->output->set_output($results);
    }

    public function juniper_nations()
    {
        $query = $this->input->get('q');
        $locres = $this->db->query("SELECT code,countries FROM pt_ejuniper_nations
         WHERE (code LIKE '%$query%' OR countries LIKE '%$query%')
        ORDER BY CASE
       WHEN (code LIKE '%$query%' AND countries LIKE '%$query%') THEN 1
        WHEN (code LIKE '%$query%' AND countries NOT LIKE '%$query%') THEN 2
         ELSE 3
         END, code")->result();

        if (!empty($locres)) {
            foreach ($locres as $l) {
                $locations[] = (object) array('id' => $l->code, 'text' => $l->countries." (".$l->code.")");
            }
            $results = json_encode($locations);
        }else{
            $results = json_encode(array("text" => "Not Found"));
        }
        $this->output->set_output($results);
    }

    public function spaAutoComplete()
    {
        $module = $this->input->get('module');
        $module = rtrim($module, 's');
        $this->db->select($module.'_title AS title');
        $dataAdapter = $this->db->get('pt_'.$module.'s');
        $html = '';
        if($dataAdapter->num_rows() > 0) {
            foreach ($dataAdapter->result() as $dataset) {
                $html .= '<option value="'.$dataset->title.'">'.$dataset->title.'</option>';
            }
        }
        $this->output->set_output(json_encode(['html' => $html]));
    }

    public function hotels()
    {
        $query = $this->input->get('q');
        $this->dbhb = getDatabaseConnection('hotelbeds');
        $this->dbhb->select('code, name');
        $this->dbhb->like('name', $query);
        $this->dbhb->group_by('code');
        $dataAdapter = $this->dbhb->get('destinations');
        $final_response = array();
        foreach($dataAdapter->result() as $dataObj)
        {
            array_push($final_response, array(
                'id' => $dataObj->code,
                'text'=> $dataObj->name
            ));
        }
        $this->output->set_output(json_encode($final_response));
    }

    /**
     * Homepage search form autocomplete function for custom hotels module
     *
     * @return json
     */
    function customHotels()
    {
        $q = $this->input->get('q');
        $query = "
            SELECT 
                pt_hotels.hotel_id as id, 
                pt_hotels.hotel_title as title, 
                pt_locations.country, 
                pt_locations.location as city
            FROM `pt_hotels` 
            LEFT JOIN `pt_locations`
            ON pt_hotels.hotel_city = pt_locations.id
            WHERE pt_hotels.hotel_title LIKE '%{$q}%'
            UNION
            SELECT id, country as title, country, location as city
            FROM `pt_locations` 
            WHERE location LIKE '%{$q}%'
        ";
        $dataset = $this->db->query($query)->result_array();
        $this->output->set_output(json_encode($dataset));
    }

    /**
     * Homepage search form autocomplete function for hotelbeds hotels module
     *
     * @return json
     */
    function hotelbedsHotels()
    {
        $this->dbhb = getDatabaseConnection('hotelbeds');
        $q = $this->input->get('q');
        $query = "
            SELECT 
                city as title, city_slug as id, countryName as country, city, city_slug
            FROM hotels 
            WHERE city LIKE '%{$q}%' 
            UNION
            SELECT 
                name as title, slug as id, countryName as country, city, city_slug
            FROM hotels 
            WHERE name LIKE '%{$q}%' 
        ";
        $dataset = $this->dbhb->query($query)->result_array();
        $arr = [];
        foreach ($dataset as $data){
            $obj = (object)[
                'id'=>$data['title']."/".$data['city'],
                'text'=>$data['title'].",".$data['city'],
                'data'=>$data
            ];
            array_push($arr,$obj);
        }
        $this->output->set_output(json_encode($arr));
    }
}