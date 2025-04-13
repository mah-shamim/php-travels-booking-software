<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Updates extends MX_Controller {

	private $jsonFile;

		function __construct() {
				parent :: __construct();
				//modules :: load('Admin');
				$isSuperAdmin = $this->session->userdata('pt_logged_super_admin');
				if(empty($isSuperAdmin)){ $this->session->set_userdata('prevURL', current_url()); redirect("admin"); 				}
				$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
				$this->data['accType'] = $this->session->userdata('pt_accountType');
				$this->data['role'] = $this->session->userdata('pt_role');
				$this->data['isSuperAdmin'] = $isSuperAdmin;
				$this->data['updateurl'] = UPDATES_ROOT_URL;
				$this->data['ptVersion'] = str_replace("v","",PT_VERSION);
				$this->lang->load("back", "en");
				$this->jsonFile =  "application/updates.json";
				$chkupdates = checkUpdatesCount();
				if(!$chkupdates->showUpdates){ exit; }
		}

		public function index() {
			$listData = curlCall(UPDATES_LIST_URL);
			$updatesList = json_decode($listData);
			$array = [];
            foreach($updatesList->list as $item) {
                if($this->data['ptVersion'] == str_replace("v","",$item->ptversion)) {
                    $array[] = $item;
                }
            }
			$this->data['updatesList'] = $array;
			$this->data['allUpdates'] = $updatesList->allUpdates;
			$this->data['updatesDone'] = $this->readUpdatesJSON();
			$this->data['allUpdated'] = $this->allUpdated($this->data['updatesDone']->updated,$updatesList->allUpdates);
			$this->data['main_content'] = 'updates';
			$this->data['page_title'] = 'Updates';
			$this->load->view('template', $this->data);
		}

		public function applyUpdate(){
			$updateKey = $this->input->post('updatekey');
			$hasSQLupdate = $this->input->post('hasSql');
			$url = UPDATES_ROOT_URL.$updateKey."/".$updateKey.".zip";

			$updateApplied = $this->UpdatesCurl($url,$updateKey);

			if($updateApplied->status == "success"){
				$this->updateJSON($updateKey);
			}

		$this->load->library('unzip');

		$this->unzip->extract('updates/'.$updateKey.'.zip','../');

	//apply sql update
	if($hasSQLupdate == "yes"){
	$sql = file_get_contents(UPDATES_ROOT_URL.$updateKey."/".$updateKey.".sql");
   foreach (explode(";---endline", $sql) as $sql)
   {
      $sql = trim($sql);
      if($sql)
      {
         $this->db->query($sql);
      }
   }
		}
		//end apply sql update



		}

		public function hideUpdate(){
			$updateKey = $this->input->post('updatekey');
			$this->updateJSON($updateKey);


		}

		public function checksql($updateKey){

			$sql = file_get_contents(UPDATES_ROOT_URL.$updateKey."/".$updateKey.".sql");
   foreach (explode(";---endline", $sql) as $sql)
   {
      $sql = trim($sql);
      if($sql)
      {
         echo $this->db->query($sql)."<br>";
      }
   }


		}

		function updateJSON($update){

			$fileData = $this->readUpdatesJSON();

			 $f = (object)$fileData;
			 if(!in_array($update, $f->updated)){
			  array_push($f->updated,$update);
			 }

			 file_put_contents($this->jsonFile, json_encode($f,JSON_PRETTY_PRINT));

		$this->db->select('updates_check');
		$this->db->where('user', 'webadmin');
		$res = $this->db->get('pt_app_settings')->result();
		$duration = $res[0]->updates_check * 3600;

		$current = time();

		$check = $this->db->get('pt_updates')->result();

		if(empty($check)){

			$lastupdate = 0;

		}else{

		$lastupdate = $check[0]->lastchecked;

		}


		$listData = curlCall(UPDATES_LIST_URL);
		$this->db->truncate('pt_updates');
		$data = array('updateslist' => $listData,'lastchecked' => $duration + $current);

		$this->db->insert('pt_updates',$data);




		}

		function readUpdatesJSON(){

		$fileData = json_decode(file_get_contents($this->jsonFile));
		return $fileData;

		}

		function allUpdated($doneupdates,$allupdates){

			$result = array_diff($allupdates,$doneupdates);

			if(empty($result)){
				return TRUE;
			}else{
				return FALSE;
			}


		}

		function UpdatesCurl($url,$updatekey){
			$result = new stdClass;

			$zipFile = "updates/".$updatekey.".zip";

			$zipResource = fopen($zipFile, "w");
			// Get The Update zip File From Server
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_FILE, $zipResource);
			$page = curl_exec($ch);
			if(!$page) {
			//echo "Error :- ".curl_error($ch);
				$result->status = "fail";
				$result->msg = curl_error($ch);
			}else{
				$result->status = "success";
				$result->msg = "";
			}
			return $result;
			curl_close($ch);

		}



}
