<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * Flights Ajax Requests Controller
 *
 * @category Controller
 */
ini_set("display_errors",1);

class AjaxController extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->output->set_content_type('application/json');

    }

    public function index()
    {
        //
    }

    /**
     * Update flights settings
     *
     * @method Backend
     * @return json
     */
    public function update_settings()
    {
        $this->load->model('flights/Flights_model');
        $configuration = new Flights_model();

        $payload = $this->input->post();
        $configuration->update_settings($payload);

        $this->output->set_output(json_encode(array(
            'status' => 'success'
        )));
    }
    function delRoute(){

        $this->load->model('flights/Flights_model');
        $configuration = new Flights_model();
        $id = $this->input->post('id');
        $configuration->delete_route($id);
        $this->output->set_output(json_encode(array(
            'status' => 'success'
        )));
    }
    function delMultipleRoutes(){
        $this->load->model('flights/Flights_model');
        $configuration = new Flights_model();

        $items = $this->input->post('items');

        foreach($items as $item){
            $configuration->delete_route_multi($item);
        }
        $this->output->set_output(json_encode(array(
            'status' => 'success'
        )));
    }
}