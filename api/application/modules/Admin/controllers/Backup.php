<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Backup extends MX_Controller {

   public $role;
//private $userid = 1; //$this->session->userdata('userid');
   function __construct(){
      parent::__construct();
      modules::load('Admin');
      $chkadmin = modules::run('Admin/validadmin');
      $superAdmin = $this->session->userdata('pt_logged_super_admin');

        if (!$chkadmin || !$superAdmin) {
          $this->session->set_userdata('prevURL', current_url());


            redirect('admin');

        }
      $this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
      $this->load->helper('directory');
      $this->load->helper('file');
      $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
      $this->data['isSuperAdmin'] = $superAdmin;
      $this->role = $this->session->userdata('pt_role');
      $this->data['role'] = $this->role;

   }
   public function index()
   {

    $upload = $this->input->post('upload');

    if(!empty($upload)){
     $this->load->model('Uploads_model');
     if(isset($_FILES['datasqlfile']) && !empty($_FILES['datasqlfile']['name'])){
       $result = $this->Uploads_model->__sqlUpload();


       if($result['done']){
          $this->session->set_flashdata('successmsg', $result['msg']);
       }else{
          $this->session->set_flashdata('errormsg', $result['msg']);
       }
    }else{
     $this->session->set_flashdata('errormsg', "Please Select file");

  }

  redirect('admin/backup');

}
$this->data['main_content'] = 'Admin/backup/backup';
$this->data['page_title'] = 'Back Up';
$this->load->view('template',$this->data);
}

 public function create()
   {

  $getbackup = $this->input->post('getbackup');
  if(!empty($getbackup)){
    $tables = $this->input->post('dbtables');

    if(empty($tables)){
      $this->session->set_flashdata('errormsg', 'No Table Selected.');
      redirect("admin/backup/create");
    }else{
      $this->getBackup($tables);
    }

  }

   $result = $this->db->query("SHOW TABLE STATUS")->result();
   $tableinfo = array();
   $totalsize = 0;
   foreach($result as $res){
    $size = round($res->Data_length/1000,2);
    $totalsize += $size;
    $toalrows += $res->Rows;
    $tableinfo['all'][] = (object)array("name" => $res->Name, "size" => $size." KB", "rows" => $res->Rows);
   }

   $tableinfo['totalSize'] = round(($totalsize/1000),2)." MB";
   $tableinfo['totalRows'] = $toalrows;

    $this->data['dbtables'] = $tableinfo;
    $this->data['main_content'] = 'Admin/backup/createbackup';
    $this->data['page_title'] = 'Create BackUp';
    $this->load->view('template',$this->data);
}

public function getBackup($tables){
   $this->load->dbutil();
   $prefs = array(
      'tables'      => $tables,
      'format'      => 'txt',
      'filename'    => 'my_db_backup.sql'
      );
   $backup =& $this->dbutil->backup($prefs);
   $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.sql';
   $save = 'backups/'.$db_name;
   $this->load->helper('file');
   write_file($save, $backup);
   $this->session->set_flashdata('flashmsgs', 'Backup Created Successfully');
   redirect("admin/backup");
}
function remove_backup(){
   $bkid = $this->input->post('bkid');
   unlink("backups/".$bkid);
   $this->session->set_flashdata('flashmsgs', 'Backup Deleted Successfully');
}
function restore_backup(){
   $sqlfile = $this->input->post('sqlfile');
   $sql=file_get_contents('backups/'.$sqlfile);
   foreach (explode(";\n", $sql) as $sql)
   {
      $sql = trim($sql);
      if($sql)
      {
         $this->db->query($sql);
      }
   }
   $this->session->set_flashdata('flashmsgs', 'Database Restored Successfully');
}
function download(){
   $file = $this->input->get('backup');
   $sql = file_get_contents('backups/'.$file);
   $this->load->helper('download');
   force_download($file, $sql);
}
function reset_database(){
   $code = $this->input->post('code');
   $tables = $this->db->list_tables();
   $notReset = array('pt_app_settings','pt_cms','pt_cms_content','pt_accounts','pt_menus','pt_menus_translation','pt_front_settings');
   $resetTables = array_diff($tables,$notReset);
   if($code == 11){
//print_r($resetTables);
      foreach($resetTables as $t){
         $this->db->truncate($t);

      }
      echo "1";
   }else{
      echo "1jhg";
   }
}
   function redirectBackup(){
      redirect('admin/backup','refresh');
   }


}
