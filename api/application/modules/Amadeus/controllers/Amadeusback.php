<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Amadeusback extends MX_Controller {

    const MODULE = "Amadeus";

    public function __construct()
    {
        parent::__construct();
        $method_segment = $this->uri->segment(3);
        // Access Checkpoint
        // Module enabled/disabled checkpoint
        $chk = $this->App->service('ModuleService')->isActive(self::MODULE);
        if ( ! $chk && $method_segment != "settings" && $method_segment != "update_settings") {
            backError_404($this->data);
        }
        $this->role    = $this->session->userdata('pt_role');

        // If user is not log in then redirect the to admin panel.
        $this->data['userloggedin'] = $this->session->userdata('pt_logged_id');

        if (empty($this->data['userloggedin']))
        {
            // Redirect user to admin/index (Admin Dashboard)
            $urisegment =  $this->uri->segment(1);

            $this->session->set_userdata('prevURL', current_url());

            redirect($urisegment);
        }

        // If user is admin then assign `admin` to segment otherwise `supplier`
        $administrator = $this->session->userdata('pt_logged_admin');

        if ( ! empty ($administrator))
        {
            $this->data['adminsegment'] = "admin";
        }
        else
        {
            $this->data['adminsegment'] = "supplier";
        }

        // Usecase 1: If someone make changes in session then this check can be helpful.

        // If segment string is `admin` then validate it otherwise validated `supplier`
        if ($this->data['adminsegment'] == "admin")
        {
            $checkpoint = modules :: run('Admin/validadmin');
            if ( ! $checkpoint) // If checkpoint become fail
            {
                redirect('admin');
            }
        }
        else
        {
            $checkpoint = modules :: run('supplier/validsupplier');
            if ( ! $checkpoint) // If checkpoint become fail
            {
                redirect('supplier');
            }
        }

        // Assign PHP Travel app settings, get it from settings table.
        $this->data['appSettings'] = modules :: run('Admin/appSettings');

        $this->data['addpermission'] = true;

        if($this->role == "supplier" || $this->role == "admin")
        {
            $this->editpermission = pt_permissions("edithotels", $this->data['userloggedin']);
            $this->deletepermission = pt_permissions("deletehotels", $this->data['userloggedin']);

            $this->data['addpermission'] = pt_permissions("addhotels", $this->data['userloggedin']);
        }

        $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
        $this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
        $this->data['page_title'] = 'Amadeus Setting';
    }

    public function index()
    {
        $this->data['main_content'] = 'Amadeus/index';
        $this->data['page_title'] = 'Amadeus Index';
        $this->data['header_title'] = 'Amadeus Index';
        $this->load->view('Admin/template', $this->data);
    }

    public function settings()
    {
        $this->data['moduleSetting'] = $this->App->service("ModuleService")->get("Amadeus");
        $this->data['main_content'] = 'Amadeus/settings';
        $this->data['page_title'] = 'Amadeus Settings';
        $this->data['header_title'] = 'Amadeus Settings';
        $this->load->view('Admin/template', $this->data);
    }

    public function update_settings()
    {
        $payload = $this->input->post();
        $this->App->service("ModuleService")->update('Amadeus', 'apiConfig', $payload['apiConfig']);
        redirect(base_url('admin/amadeus/settings'));
    }

    /**
     * Bookings
     *
     * @return html
     */
    public function bookings()
    {
        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_amadeus_booking');
        $xcrud->columns(array('firstname','email','phone','country','currency','totalTaxes','totalPrice','commission','total_with_commission','total_amount_with_tax','status'));
        $xcrud->label(array('totalTaxes' => 'Tax','total_amount_with_tax'=>'Grand Total','country'=>"Nationality","totalPrice"=>"Flight Price","total_with_commission"=>'Total'));
        $flight_segments = $xcrud->nested_table('pt_amadeus_booking','id','pt_amadeus_flight_segments','booking_id'); // 2nd level
        $flight_segments->columns(array('carrier_code','iataCode_departure','iataCode_arrival','departure_at','arrival_at'));
        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Amadeus Booking Management';
        $this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'pt_amadeus_booking';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Booking Management';
        $this->load->view('Admin/template', $this->data);
    }

    /**
     * Delete multiple records
     *
     * Serves XCRUD delete all method
     *
     * @return json
     */
    public function delete_multiple_record()
    {
        $this->db->where_in('id', $this->input->post('items'));
        $this->db->delete('pt_Amadeus_booking');
        $this->output->set_output(json_encode(array(
            'data' => $this->input->post()
        )));
    }

    public function getHotels()
    {
        $hotel = new AmadeusStaticContent();
        $hotel->hotels();
    }

    public function getDestinations()
    {
        $hotel = new AmadeusStaticContent();
        $hotel->Destinations();
    }

    public function getAccommodations()
    {
        $hotel = new AmadeusStaticContent();
        $hotel->Accommodations();
    }

    public function getBoards()
    {
        $hotel = new AmadeusStaticContent();
        $hotel->Boards();
    }

    public function getChains()
    {
        $hotel = new AmadeusStaticContent();
        $hotel->Chains();
    }

    public function getCurrencies()
    {
        $hotel = new AmadeusStaticContent();
        $hotel->Currencies();
    }

    public function getFacilities()
    {
        $hotel = new AmadeusStaticContent();
        $hotel->Facilities();
    }

    public function getFacilitytypologies()
    {
        $hotel = new AmadeusStaticContent();
        $hotel->Facilitytypologies();
    }

    /**
     * Synching
     */
    public function sync()
    {
        // $this->syncHotels();
        // $this->syncFacilities();
    }

    public function syncHotels()
    {
        $aCountris = array();
        $countries = $this->dbhb->get('countries')->result();
        foreach ($countries as $country) {
            $aCountris[$country->code] = $country->description;
        }
        ini_set('memory_limit', '-1');
        ini_set('display_errors', 1);
        $f = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'w');
        fwrite($f, 'syncing start: '. date('H:i:s') . PHP_EOL);

        $batchLimit = 100;
        $from = 1;
        $to = 100;
        $step = 100;
        $running = TRUE;
        $lock = FALSE;
        $data = [];
        while ($running)
        {
//            $file = __DIR__ . sprintf('/../libraries/ReferenceData/Hotels/hotels-%s-%s.json', $from, $to);
            $file = sprintf(self::HOTELBED_CONTENT_PATH.'/Hotels/hotels-%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
            } else {
                $fr = fopen($file, 'r');
                $dataset = fread($fr, filesize($file));
                fclose($fr);
            }

            if( ! empty($dataset) )
            {
                if( ! $lock )
                {
                    // Refresh table
                    $this->dbhb->empty_table($this::TB_HOTELS);
                    $lock = TRUE;
                }

                foreach(json_decode($dataset)->hotels as $hotel) {
                    array_push($data, array(
                        'code' => $hotel->code,
                        'name' => $hotel->name->content,
                        'description' => $hotel->description->content,
                        'countryCode' => $hotel->countryCode,
                        'countryName' => $aCountris[$hotel->countryCode],
                        'city' => $hotel->city->content,
                        'destinationCode' => $hotel->destinationCode,
                        'latitude' => $hotel->coordinates->latitude,
                        'longitude' => $hotel->coordinates->longitude,
                        'images' => (isset($hotel->images))?json_encode($hotel->images):NULL,
                        'ratingStars' => $hotel->categoryCode[0], // 3Stars
                        'address' => $hotel->address->content
                    ));

                    if(count($data) >= $batchLimit) {
                        fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                        $this->dbhb->insert_batch($this::TB_HOTELS, $data);
                        $data = [];
                    }
                }
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        if(count($data) > 0) {
            fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
            $this->dbhb->insert_batch($this::TB_HOTELS, $data);
            $data = [];
        }

        fwrite($f, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($f);
    }

    public function syncAccommodations()
    {
        $f = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'w');
        fwrite($f, 'syncing start: '. date('H:i:s') . PHP_EOL);

        $batchLimit = 100;
        $from = 1;
        $to = 100;
        $step = 100;
        $running = TRUE;
        $lock = FALSE;
        $data = [];
        while ($running)
        {
            $file = __DIR__ . sprintf('/../libraries/ReferenceData/Accommodations/accommodations-%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
            } else {
                $fr = fopen($file, 'r');
                $dataset = fread($fr, filesize($file));
                fclose($fr);
            }

            if( ! empty($dataset) )
            {
                if( ! $lock )
                {
                    // Refresh table
                    $this->dbhb->empty_table($this::TB_ACCOMMODATIONS);
                    $lock = TRUE;
                }

                foreach(json_decode($dataset)->accommodations as $accommodation) {
                    array_push($data, array(
                        'code' => $accommodation->code,
                        'description' => $accommodation->typeMultiDescription->content
                    ));

                    if(count($data) >= $batchLimit) {
                        fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                        $this->dbhb->insert_batch($this::TB_ACCOMMODATIONS, $data);
                        $data = [];
                    }
                }
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        if(count($data) > 0) {
            fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
            $this->dbhb->insert_batch($this::TB_ACCOMMODATIONS, $data);
        }

        fwrite($f, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($f);
    }

    public function syncFacilityGroups()
    {
        echo 'syncing...';
        $batchLimit = 1000;

        $log = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'a');
        fwrite($log, 'syncing start: '. date('H:i:s') . PHP_EOL);

        // Read file
        $file = __DIR__ . '/../libraries/ReferenceData/FacilityGroups.json';
        if ( ! file_exists($file) ) {
            die('Accommodations file not found');
        }

        $fr = fopen($file, 'r');
        $dataset = fread($fr, filesize($file));
        fclose($fr);

        if( ! empty($dataset) )
        {
            // Refresh table
            $this->dbhb->empty_table($this::TB_FACILITYGROUPS);

            $data = [];
            foreach(json_decode($dataset)->facilityGroups as $facilityGroup) {
                array_push($data, array(
                    'code' => $facilityGroup->code,
                    'description' => $facilityGroup->description->content
                ));

                if(count($data) >= $batchLimit) {
                    fwrite($log, 'batch insert: ' . count($data) . PHP_EOL);
                    $this->dbhb->insert_batch($this::TB_FACILITYGROUPS, $data);
                    $data = [];
                }
            }
            if(count($data) > 0) {
                fwrite($log, 'batch insert: ' . count($data) . PHP_EOL);
                $this->dbhb->insert_batch($this::TB_FACILITYGROUPS, $data);
            }
        }

        fwrite($log, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($log);
    }

    public function syncDestinations()
    {
        $f = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'w');
        fwrite($f, 'syncing start: '. date('H:i:s') . PHP_EOL);

        $batchLimit = 100;
        $from = 1;
        $to = 100;
        $step = 100;
        $running = TRUE;
        $lock = FALSE;
        while ($running)
        {
            $file = __DIR__ . sprintf('/../libraries/ReferenceData/Destinations/%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
            }

            $fr = fopen($file, 'r');
            $dataset = fread($fr, filesize($file));
            fclose($fr);

            if( ! empty($dataset) )
            {
                if( ! $lock )
                {
                    // Refresh table
                    $this->dbhb->empty_table($this::TB_DESTINATIONS);
                    $lock = TRUE;
                }

                $data = [];
                foreach(json_decode($dataset)->destinations as $destination) {
                    array_push($data, array(
                        'code' => $destination->code,
                        'name' => $destination->name->content,
                        'countryCode' => $destination->countryCode
                    ));

                    if(count($data) >= $batchLimit) {
                        fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                        $this->dbhb->insert_batch($this::TB_DESTINATIONS, $data);
                        $data = [];
                    }
                }
                if(count($data) > 0) {
                    fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                    $this->dbhb->insert_batch($this::TB_DESTINATIONS, $data);
                }
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        fwrite($f, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($f);
    }

    public function syncBoards()
    {
        $f = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'w');
        fwrite($f, 'syncing start: '. date('H:i:s') . PHP_EOL);

        $batchLimit = 1000;
        $from = 1;
        $to = 1000;
        $step = 1000;
        $running = TRUE;
        $lock = FALSE;
        while ($running)
        {
            $file = __DIR__ . sprintf('/../libraries/ReferenceData/Boards/%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
            }

            $fr = fopen($file, 'r');
            $dataset = fread($fr, filesize($file));
            fclose($fr);

            if( ! empty($dataset) )
            {
                if( ! $lock )
                {
                    // Refresh table
                    $this->dbhb->empty_table($this::TB_BOARDS);
                    $lock = TRUE;
                }

                $data = [];
                foreach(json_decode($dataset)->boards as $board) {
                    array_push($data, array(
                        'code' => $board->code,
                        'description' => $board->description->content
                    ));

                    if(count($data) >= $batchLimit) {
                        fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                        $this->dbhb->insert_batch($this::TB_BOARDS, $data);
                        $data = [];
                    }
                }
                if(count($data) > 0) {
                    fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                    $this->dbhb->insert_batch($this::TB_BOARDS, $data);
                }
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        fwrite($f, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($f);
    }

    public function syncCountries()
    {
        ini_set('display_errors', 1);
        $f = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'w');
        fwrite($f, 'syncing start: '. date('H:i:s') . PHP_EOL);

        $batchLimit = 1000;
        $from = 1;
        $to = 100;
        $step = 100;
        $running = TRUE;
        $lock = FALSE;
        while ($running)
        {
            $file = sprintf(self::HOTELBED_CONTENT_PATH.'/Countries/%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
            }

            $fr = fopen($file, 'r');
            $dataset = fread($fr, filesize($file));
            fclose($fr);

            if( ! empty($dataset) )
            {
                if( ! $lock )
                {
                    // Refresh table
                    $this->dbhb->empty_table($this::TB_COUNTIRES);
                    $lock = TRUE;
                }

                $data = [];
                foreach(json_decode($dataset)->countries as $country) {
                    array_push($data, array(
                        'code' => $country->code,
                        'isoCode' => $country->isoCode,
                        'description' => $country->description->content
                    ));

                    if(count($data) >= $batchLimit) {
                        fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                        $this->dbhb->insert_batch($this::TB_COUNTIRES, $data);
                        $data = [];
                    }
                }
                if(count($data) > 0) {
                    fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                    $this->dbhb->insert_batch($this::TB_COUNTIRES, $data);
                }
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        fwrite($f, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($f);
    }

    public function syncCategories()
    {
        $f = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'w');
        fwrite($f, 'syncing start: '. date('H:i:s') . PHP_EOL);

        $batchLimit = 1000;
        $from = 1;
        $to = 1000;
        $step = 1000;
        $running = TRUE;
        $lock = FALSE;
        while ($running)
        {
            $file = __DIR__ . sprintf('/../libraries/ReferenceData/Categories/%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
            }

            $fr = fopen($file, 'r');
            $dataset = fread($fr, filesize($file));
            fclose($fr);

            if( ! empty($dataset) )
            {
                if( ! $lock )
                {
                    // Refresh table
                    $this->dbhb->empty_table($this::TB_CATEGORIES);
                    $lock = TRUE;
                }

                $data = [];
                foreach(json_decode($dataset)->categories as $category) {
                    array_push($data, array(
                        'code' => $category->code,
                        'accommodationType' => $category->accommodationType,
                        'group' => $category->group,
                        'description' => $category->description->content
                    ));

                    if(count($data) >= $batchLimit) {
                        fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                        $this->dbhb->insert_batch($this::TB_CATEGORIES, $data);
                        $data = [];
                    }
                }
                if(count($data) > 0) {
                    fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                    $this->dbhb->insert_batch($this::TB_CATEGORIES, $data);
                }
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        fwrite($f, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($f);
    }

    public function syncChains()
    {
        $f = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'w');
        fwrite($f, 'syncing start: '. date('H:i:s') . PHP_EOL);

        $batchLimit = 1000;
        $from = 1;
        $to = 1000;
        $step = 1000;
        $running = TRUE;
        $lock = FALSE;
        while ($running)
        {
            $file = __DIR__ . sprintf('/../libraries/ReferenceData/Chains/%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
            }

            $fr = fopen($file, 'r');
            $dataset = fread($fr, filesize($file));
            fclose($fr);

            if( ! empty($dataset) )
            {
                if( ! $lock )
                {
                    // Refresh table
                    $this->dbhb->empty_table($this::TB_CHAINS);
                    $lock = TRUE;
                }

                $data = [];
                foreach(json_decode($dataset)->chains as $chain) {
                    array_push($data, array(
                        'code' => $chain->code,
                        'description' => $chain->description->content
                    ));

                    if(count($data) >= $batchLimit) {
                        fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                        $this->dbhb->insert_batch($this::TB_CHAINS, $data);
                        $data = [];
                    }
                }
                if(count($data) > 0) {
                    fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                    $this->dbhb->insert_batch($this::TB_CHAINS, $data);
                }
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        fwrite($f, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($f);
    }

    public function syncCurrencies()
    {
        $f = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'w');
        fwrite($f, 'syncing start: '. date('H:i:s') . PHP_EOL);

        $batchLimit = 1000;
        $from = 1;
        $to = 1000;
        $step = 1000;
        $running = TRUE;
        $lock = FALSE;
        while ($running)
        {
            $file = __DIR__ . sprintf('/../libraries/ReferenceData/Currencies/%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
            }

            $fr = fopen($file, 'r');
            $dataset = fread($fr, filesize($file));
            fclose($fr);

            if( ! empty($dataset) )
            {
                if( ! $lock )
                {
                    // Refresh table
                    $this->dbhb->empty_table($this::TB_CURRENCIES);
                    $lock = TRUE;
                }

                $data = [];
                foreach(json_decode($dataset)->currencies as $currency) {
                    array_push($data, array(
                        'code' => $currency->code,
                        'currencyType' => $currency->currencyType,
                        'description' => $currency->description->content
                    ));

                    if(count($data) >= $batchLimit) {
                        fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                        $this->dbhb->insert_batch($this::TB_CURRENCIES, $data);
                        $data = [];
                    }
                }
                if(count($data) > 0) {
                    fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                    $this->dbhb->insert_batch($this::TB_CURRENCIES, $data);
                }
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        fwrite($f, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($f);
    }

    public function syncFacilities()
    {
        $f = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'w');
        fwrite($f, 'syncing start: '. date('H:i:s') . PHP_EOL);

        $batchLimit = 100;
        $from = 1;
        $to = 100;
        $step = 100;
        $running = TRUE;
        $lock = FALSE;
        while ($running)
        {
            $file = __DIR__ . sprintf('/../libraries/ReferenceData/Facilities/%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
            } else {
                $fr = fopen($file, 'r');
                $dataset = fread($fr, filesize($file));
                fclose($fr);
            }

            if( ! empty($dataset) )
            {
                if( ! $lock )
                {
                    // Refresh table
                    $this->dbhb->empty_table($this::TB_FACILITIES);
                    $lock = TRUE;
                }

                $data = [];
                foreach(json_decode($dataset)->facilities as $facility) {
                    array_push($data, array(
                        'code' => $facility->code,
                        'facilityGroupCode' => $facility->facilityGroupCode,
                        'facilityTypologyCode' => $facility->facilityTypologyCode,
                        'description' => $facility->description->content
                    ));

                    if(count($data) >= $batchLimit) {
                        fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                        $this->dbhb->insert_batch($this::TB_FACILITIES, $data);
                        $data = [];
                    }
                }
                if(count($data) > 0) {
                    fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                    $this->dbhb->insert_batch($this::TB_FACILITIES, $data);
                }
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        fwrite($f, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($f);
    }

    public function syncFacilitytypologies()
    {
        $f = fopen(__DIR__ . '/../libraries/ReferenceData/sync-log.txt', 'w');
        fwrite($f, 'syncing start: '. date('H:i:s') . PHP_EOL);

        $batchLimit = 1000;
        $from = 1;
        $to = 1000;
        $step = 1000;
        $running = TRUE;
        $lock = FALSE;
        while ($running)
        {
            $file = __DIR__ . sprintf('/../libraries/ReferenceData/Facilitytypologies/%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
            }

            $fr = fopen($file, 'r');
            $dataset = fread($fr, filesize($file));
            fclose($fr);

            if( ! empty($dataset) )
            {
                if( ! $lock )
                {
                    // Refresh table
                    $this->dbhb->empty_table($this::TB_FACILITYTYPOLOGIES);
                    $lock = TRUE;
                }

                $data = [];
                foreach(json_decode($dataset)->facilityTypologies as $facilityTypology) {
                    array_push($data, array(
                        'code' => $facilityTypology->code,
                        'full_response' => json_encode($facilityTypology)
                    ));

                    if(count($data) >= $batchLimit) {
                        fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                        $this->dbhb->insert_batch($this::TB_FACILITYTYPOLOGIES, $data);
                        $data = [];
                    }
                }
                if(count($data) > 0) {
                    fwrite($f, 'batch insert: ' . count($data) . PHP_EOL);
                    $this->dbhb->insert_batch($this::TB_FACILITYTYPOLOGIES, $data);
                }
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        fwrite($f, 'syncing end: '. date('H:i:s') . PHP_EOL);
        fclose($f);
    }
}