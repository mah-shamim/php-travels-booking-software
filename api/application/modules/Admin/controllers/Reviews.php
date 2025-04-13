<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reviews extends MX_Controller {
public $role;
function __construct(){
modules::load('Admin');
$chkadmin = modules::run('Admin/validadmin');
if(!$chkadmin){
        $this->session->set_userdata('prevURL', current_url());
redirect('admin');
}
$chk = modules::run('Home/is_module_enabled','hotels');
if(!$chk){

redirect('admin');
}
$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
$this->role = $this->session->userdata('pt_role');
$this->data['role'] = $this->role;

if(!pt_permissions('reviews',$this->data['userloggedin'])){
redirect('admin');
}
$this->load->model('Reviews_model');
$this->data['modModel'] = $this->modules_model;
}





function listings($module = null,$items = null){
        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();

                  if(!empty($items)){
              $this->data['itemslist'] = $items;


                  }

        $xcrud->table('pt_reviews');
        if(!empty($module)){
            $xcrud->where('review_module',$module);
        }


        if ($module == "hotels") {
        $xcrud->join('review_itemid','pt_hotels','hotel_id');
        $xcrud->columns('pt_hotels.hotel_title');
        $xcrud->label('pt_hotels.hotel_title','Hotel');

        }elseif($module == "tours"){

        $xcrud->join('review_itemid','pt_tours','tour_id');
        $xcrud->columns('pt_tours.tour_title');
        $xcrud->label('pt_tours.tour_title','Tour');

        }
        $xcrud->order_by('review_id','desc');
        $xcrud->columns('review_name,review_email,review_date,review_overall,review_status');
        $xcrud->label('review_name','Name')->label('review_email','Email')->label('review_date','Date')->label('review_overall','Overall')->label('review_status','Status')->label('review_comment','Comments');
        $xcrud->fields('review_name,review_email,review_comment,review_status', false, 'Traveller');
        $xcrud->fields('review_clean,review_comfort,review_location,review_facilities,review_staff,review_overall', false, 'Overall');
        $xcrud->set_attr('review_overall',array('id'=>'overall'));
        $xcrud->set_attr('review_clean',array('onchange' =>'getReviewScore(this.value)'));
        $xcrud->set_attr('review_comfort',array('onchange' =>'getReviewScore(this.value)'));
        $xcrud->set_attr('review_location',array('onchange' =>'getReviewScore(this.value)'));
        $xcrud->set_attr('review_facilities',array('onchange' =>'getReviewScore(this.value)'));
        $xcrud->set_attr('review_staff',array('onchange' =>'getReviewScore(this.value)'));
        $xcrud->readonly('review_overall');

        $xcrud->column_callback('review_date', 'fmtDate');
        $xcrud->limit(50);
        $xcrud->unset_add();
        $xcrud->unset_view();
        $xcrud->unset_remove();

        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Reviews Management';
        $this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'pt_reviews';
        $this->data['main_key'] = 'review_id';
        $this->data['header_title'] = 'Reviews Management';
        $this->load->view('template', $this->data);

        }

}
