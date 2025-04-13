<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reviews extends MX_Controller {


    public $role;


	function __construct(){

    modules::load('supplier');
       $chkadmin = modules::run('Supplier/validsupplier');
   if(!$chkadmin){
    $this->session->set_userdata('prevURL', current_url());
      redirect('supplier');
   }
 $chk = modules::run('home/is_module_enabled','reviews');
 if(!$chk){
       redirect('supplier');
   }
       $this->data['issupplier'] = $this->session->userdata('pt_logged_supplier');
     $this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');
     $this->role = $this->session->userdata('pt_role');
        $this->data['role'] = $this->role;

   if(!pt_permissions('reviews',$this->data['issupplier'])){

     redirect('supplier');
   }

    $this->load->model('Admin/Reviews_model');
    $this->load->model('Supplier_reviews_model');
    $this->data['modModel'] = $this->modules_model;
 }

    function index(){

      $this->data['allreviews'] = $this->Supplier_reviews_model->get_all_reviews($this->data['issupplier']);

    $this->data['main_content'] = 'modules/reviews/reviews';
	$this->data['page_title'] = 'Reviews';
	$this->load->view('Admin/template',$this->data);


   }


      function add(){


     $addreview = $this->input->post('addreview');
    if(!empty($addreview)){

    $this->form_validation->set_rules('reviews_name','Name', 'trim|required');
   $this->form_validation->set_rules('reviews_for_id','Review for', 'required');
   $this->form_validation->set_rules('reviewmodule','Module', 'required');
   $this->form_validation->set_rules('reviewsdate','Date', 'trim|required');
   $this->form_validation->set_rules('reviews_comments','Comment', 'trim|required');


  if ($this->form_validation->run() == FALSE)
		{

             echo  '<div class="alert alert-danger"><i class="fa fa-times-circle"></i> '.validation_errors().'</div><br>';



		}else{
     $this->Reviews_model->add_review();
   $this->session->set_flashdata('flashmsgs', 'Review added Successfully');
    echo "done";
  	}




    }else{


   $this->data['modules'] = $this->Modules_model->get_module_names();

  $this->data['main_content'] = 'modules/reviews/add';
	$this->data['page_title'] = 'Add Review';

	$this->load->view('Admin/template',$this->data);


    }






  }


    function manage($id){


     if(empty($id)){
     redirect('supplier/reviews');

     }



     $updatereview = $this->input->post('updatereview');
    if(!empty($updatereview)){

    $this->form_validation->set_rules('reviews_name','Name', 'trim|required');
   $this->form_validation->set_rules('reviews_for_id','Review for', 'required');
   $this->form_validation->set_rules('reviewmodule','Module', 'required');
   $this->form_validation->set_rules('reviewsdate','Date', 'trim|required');
   $this->form_validation->set_rules('reviews_comments','Comment', 'trim|required');


  if ($this->form_validation->run() == FALSE)
		{

             echo  '<div class="alert alert-danger"><i class="fa fa-times-circle"></i> '.validation_errors().'</div><br>';



		}else{




   $this->Reviews_model->update_review($id);
   $this->session->set_flashdata('flashmsgs', 'Review Updated Successfully');
    echo "done";



		}




    }else{


   $this->data['modules'] = $this->Modules_model->get_module_names();

    $this->data['details'] = $this->Reviews_model->get_review_data($id);
    $this->data['moduleitems'] = $this->Modules_model->get_supplier_module_items_all($this->data['details'][0]->review_module, $this->data['issupplier']);


    $this->data['main_content'] = 'modules/reviews/manage';
	$this->data['page_title'] = 'Reviews';
	$this->load->view('Admin/template',$this->data);


    }







    }



     // Delete Single Review
    public function delete_review(){

     $reviewid = $this->input->post('reviewid');
     $this->Reviews_model->delete_review($reviewid);
     $this->session->set_flashdata('flashmsgs', "Deleted Successfully");

    }

     // Disable Review
    public function disable_review(){

     $reviewlist = $this->input->post('reviewlist');

 foreach($reviewlist as $id){

         $this->Reviews_model->disable_review($id);

     }

     $this->session->set_flashdata('flashmsgs', "Disabled Successfully");

    }


    // Enable Review
    public function enable_review(){

     $reviewlist = $this->input->post('reviewlist');

     foreach($reviewlist as $id){

         $this->Reviews_model->enable_review($id);

     }

     $this->session->set_flashdata('flashmsgs', "Enabled Successfully");

    }

     // Delete multiple Reviews
    public function delete_multiple_reviews(){

     $reviewlist = $this->input->post('reviewlist');

     foreach($reviewlist as $id){

         $this->Reviews_model->delete_review($id);

     }

     $this->session->set_flashdata('flashmsgs', "Deleted Successfully");

    }



    }
