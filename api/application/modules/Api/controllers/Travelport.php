<?php
// header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
// require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Travelport extends MX_Controller {

    private $access = TRUE;

    function __construct()
    {
        // Construct our parent class
        parent :: __construct();

        $this->output->set_content_type('application/json');

        $mobile = mobileSettings("apiKey");
        $user_api_key = $mobile->apiKey;
        $api_Key = $this->input->get('appKey');

        if( $user_api_key != $api_Key)
        {
            // Output the data
            $this->output->set_output(json_encode([
                'status' => 'fail',
                'message' => 'Invalid App Key'
            ]));

            // Display the data and exit execution
            $this->output->_display();
            exit;
        }

        // Load travelport model and populate search form with default values
		$this->load->model('Travelport_flight/TravelportModel_Conf');
		$this->travelportConfiguration = new TravelportModel_Conf();
		$this->travelportConfiguration->load();
    }

    /**
	 * Flight listing default
	 *
	 * @return html
	 */
	public function flights()
	{
        $datetime = new DateTime('tomorrow');
		$payload = array();
		$payload['origin'] = $this->travelportConfiguration->default_origin;
        $payload['destination'] = $this->travelportConfiguration->default_destination;
        $payload['departure'] = $datetime->format('Y-m-d');
        $payload['arrival'] = '';
        $payload['triptype'] = 'oneway';
        $payload['cabinclass'] = 'economy';
        $payload['passenger']['adult'] = 1;
        $payload['passenger']['children'] = 0;
        $payload['passenger']['infant'] = 0;
        $payload['passenger']['total'] = 1;

		try {
            // Save query in session for php request
            $this->session->set_userdata(['searchQuery' => $payload]);

			$flight = modules::load('Travelport_flight/flight');
            $dataset = $flight->get_response($payload);
            $total_flights = $dataset['totalListingFound'];
            unset($dataset['totalListingFound']);
            foreach($dataset as $index_1 => $data) {
                foreach($data as $index_2 => $response) {
                    $_array['outbound'] = $response[0];
                    if (isset($response[1])) {
                        $_array['inbound'] = $response[1];
                    }
                    $_array['price'] = $response['price'];
                    $data[$index_2] = $_array;
                }
                $dataset[$index_1] = $data;
            }
            $this->output->set_output(json_encode([
                'status' => 'success',
                'total_flights' => $total_flights,
                'data' => $dataset
            ]));
		}
		//catch exception
		catch(Exception $e) {
            $this->output->set_output(json_encode([
                'status' => 'fail',
                'error' => array(
                    'message' => $e->getMessage()
                )
            ]));
		}
	}

    public function search()
    {
        $payload = $this->input->get();
        $this->form_validation->set_data($payload);

        $this->form_validation->set_rules('origin', 'Origin Airport Code', 'trim|required');
        $this->form_validation->set_rules('destination', 'Destination Airport Code', 'trim|required');
        $this->form_validation->set_rules('departure', 'Departure date', 'trim|required');
        $this->form_validation->set_rules('arrival', 'Arrival date (for round trip)', 'trim');
        $this->form_validation->set_rules('triptype', 'Trip type (oneway/round)', 'trim|required');
        $this->form_validation->set_rules('cabinclass', 'Cabin class (economy,buisness,first)', 'trim|required');
        $this->form_validation->set_rules('passenger[adult]', 'Passegner type (adult)', 'trim|required');
        $this->form_validation->set_rules('passenger[children]', 'Passegner type (children)', 'trim|required');
        $this->form_validation->set_rules('passenger[infant]', 'Passegner type (infant)', 'trim|required');
        $this->form_validation->set_rules('passenger[total]', 'Total number of passengers', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode([
                'status' => 'error',
                'errors' => $this->form_validation->error_array()
            ]));
        }
        else
        {
            try {
                // Save query in session for php request    
                $this->session->set_userdata(['searchQuery' => $payload]);
    
                $flight = modules::load('Travelport_flight/flight');
                $dataset = $flight->get_response($payload);
                $total_flights = $dataset['totalListingFound'];
                unset($dataset['totalListingFound']);
                foreach($dataset as $index_1 => $data) {
                    foreach($data as $index_2 => $response) {
                        $_array['outbound'] = $response[0];
                        if (isset($response[1])) {
                            $_array['inbound'] = $response[1];
                        }
                        $_array['price'] = $response['price'];
                        $data[$index_2] = $_array;
                    }
                    $dataset[$index_1] = $data;
                }
                $this->output->set_output(json_encode([
                    'status' => 'success',
                    'total_flights' => $total_flights,
                    'data' => $dataset
                ]));
            } catch(Exception $e) {
                $this->output->set_output(json_encode([
                    'status' => 'fail',
                    'message' => $e->getMessage()
                ]));
            }
        }
    }

    /**
     * Flights checkout method
     *
     * @method post
     * @return json
     */
    public function checkout()
    {
        $this->form_validation->set_rules('outbound', 'Outbound segment key', 'trim|required');
        $this->form_validation->set_rules('inbound', 'Inbound segment key', 'trim');
        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode([
                'status' => 'error',
                'errors' => $this->form_validation->error_array()
            ]));
        }
        else
        {
            try {
                $cart = modules::load('Travelport_flight/Cart');
                $payload = $this->input->post();
                $dataset = $cart->get_response($payload);
                $this->output->set_output(json_encode([
                    'status' => 'success',
                    'data' => $dataset
                ]));
            } catch(Exception $e) {
                $this->output->set_output(json_encode([
                    'status' => 'fail',
                    'message' => $e->getMessage()
                ]));
            }
        }
    }

    /**
     * Place an order for flight reservation
     *
     * @param  booking form parameters
     * @method post
     * @return json
     */
     public function placeorder()
     {
         $this->form_validation->set_rules('title[]', 'Title (Mr/Ms/Miss/Mrs/Master)', '');
         $this->form_validation->set_rules('firstname[]', 'First name', '');
         $this->form_validation->set_rules('lastname[]', 'Last name', '');
         $this->form_validation->set_rules('phone[]', 'Phone number', '');
         $this->form_validation->set_rules('email[]', 'Email address', '');
         $this->form_validation->set_rules('nationality[]', 'Nationality', '');
         $this->form_validation->set_rules('code[]', 'Passenger Code (ADT/CNN/INF)', '');
         $this->form_validation->set_rules('formsCount', 'Total number of passenger forms', 'trim|required');
         $this->form_validation->set_rules('cardtype', 'Card type (AX/DS/CA/VI)', 'trim|required');
         $this->form_validation->set_rules('cardno', 'Credit/Debit card number', 'trim|required');
         $this->form_validation->set_rules('expMonth', 'Expiary month', 'trim|required');
         $this->form_validation->set_rules('expYear', 'Expiary year', 'trim|required');
         $this->form_validation->set_rules('cvv', 'Card Verification Value (CVV)', 'trim|required');
         if ($this->form_validation->run() == FALSE) {
             $this->output->set_output(json_encode([
                 'status' => 'error',
                 'errors' => $this->form_validation->error_array()
             ]));
         }
         else
         {
             try {
                 // Set user id
                 $this->session->set_userdata(array(
                     'pt_logged_customer' => $this->input->post('userId')
                 ));

                 $cart = modules::load('Travelport_flight/Cart');
                 $passengerForm = $this->input->post();
                 $passengerForm['formsCount'] = (count($_POST['title']) - 1);
                 $dataset = $cart->get_placeorder_response($passengerForm);
                 $this->output->set_output(json_encode([
                     'status' => 'success',
                     'data' => $dataset
                 ]));
             } catch(Exception $e) {
                 $this->output->set_output(json_encode([
                     'status' => 'fail',
                     'message' => $e->getMessage()
                 ]));
             }
         }
     }
}