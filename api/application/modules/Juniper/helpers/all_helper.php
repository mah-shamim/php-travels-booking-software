<?php
if ( ! function_exists("json_change_key")) {
    function json_change_key($arr, $oldkey, $newkey) {
        $json = str_replace('"' . $oldkey . '":', '"' . $newkey . '":', json_encode($arr)); 
        return json_decode($json, true); 
    }
}

if ( ! function_exists("calculate_commission")) {
    function calculate_commission($amount,$commission_pecentage){
        $amount = ($amount*($commission_pecentage/100))+$amount;
        return $amount;
    }
}

if ( ! function_exists("abbreviation")) {
    function abbreviation($abbreviation){
        $abbreviation_array = array(
            'RB' => 'Overnight and breakfast', 
            'RL' => 'Overnight and lunch',
            'RD' => 'Overnight and dinner',
            'RO' => 'Overnight only',
            'FB' => 'Full board',
            'H' => 'Hot Buffet',
            'C' => 'Continental',
            'B' => 'Cold Buffet',
            'A' => 'American',
            'V' => 'V',
            'R' => 'Irish',
            'I' => 'Israeli',
            'O' => 'Room Service(Continental)',
            'S' => 'Scandinavian',
            'E' => 'English',
            'T' => 'Scottish',
            'X' => 'No breakfast',
            'SGL'=> 'single room',
            'TSU' => 'twin for sole use room',
            'TWN' => 'twin room',
            'DBL' => 'double room',
            'TRP' => 'triple room',
            'QUD' => 'quadruple room',
            'FAM' => 'Family Room (2 adult + 2 extrabed)',
            "01" => "City center",
            "02"=> "Airport",
            "03"=> "Railway station",
            "04" =>"Port",
            "05" =>"Sea/Beach",
            "06" =>"Open country",
            "07" =>"Mountains",
            "08" =>"Periferals",
            "09" =>"Close to city centre"
        );
        return ucfirst($abbreviation_array[$abbreviation]);
    }


}

if ( ! function_exists("get_city_name")) {
    function get_city_name($id){
        $ci=& get_instance();
        $ci->load->database();
        $ci->db->where('city_code',$id);
        $data = $ci->db->get('pt_ejuniper_cities')->row_array();
        return $data['city_name'];
    }
}

if (!function_exists('clean_data')) {
    function clean_data($data)
    {   
        $ci =& get_instance();
        $ci->load->database();

        $variable = htmlspecialchars($data);
        $variable = trim($variable);
        $variable = strip_tags($variable);
        return $variable;
    }   


}

