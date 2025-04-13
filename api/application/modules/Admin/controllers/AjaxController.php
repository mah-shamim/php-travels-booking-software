<?php if ( ! defined('BASEPATH') ) exit ('No direct script access allowed');

class AjaxController extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function updateStatus() 
    {
        $status = NULL;
        $modulename = $this->input->post('modulename');
        $parentid = $this->input->post('parentid');
        $status = $this->input->post('status');
        $moduleService = $this->App->service('ModuleService');
        // if($modulename != 'Reviews' && $modulename!='Newsletter' &&  $modulename!='Locations' && $modulename!='Coupons' && $modulename!='Tripadvisor'){
        //     $moduleService->addpagemodule($modulename,$parentid);
        // } 

        $module = $moduleService->getstatus($parentid,$modulename,$status);

//        if($module->active) {
//            $status = 0;
//            $moduleService->disable($modulename);
//        } else {
//            $status = 1;
//            $moduleService->enable($modulename);
//        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode([
            'status' => ($status) ? 'enabled' : 'disabled'
        ]));
    }

    public function updateOrder()
    {
        $modulename = $this->input->post('modulename');
        $order = $this->input->post('order');
        $moduleService = $this->App->service('ModuleService');
        if($order == 'up') {
            $moduleService->moveup($modulename);
        } else {
            $moduleService->movedown($modulename);
        }
    }

    public function order_set(){
        $modulename = $this->input->post('modulename');
        $order = $this->input->post('order');
        $moduleService = $this->App->service('ModuleService');
        $moduleService->setorder($modulename,$order);
    }

        public function main_order_set(){
        $modulename2 = $this->input->post('modulename');
        $order2 = $this->input->post('ordering');
        $this->db->set('order',$order2);
        $this->db->where("parent_id",$modulename2);
        $this->db->update('modules');
    }

    public function order_reset(){
        $moduleService = $this->App->service('ModuleService');
        $moduleService->resetorder();
    }

    /*Hotel Beds Check Database Connection*/
    public function dbckeck(){
        $mysqli = new mysqli(  $this->input->post('hostname'), $this->input->post('username'), $this->input->post('password') , $this->input->post('databasename') );
        if( !$mysqli->connect_error )
        {
        echo "Database connected";
        }
        else{
        echo "Database not connected";
        }

    }
}