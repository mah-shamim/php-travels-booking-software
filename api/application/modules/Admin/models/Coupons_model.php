<?php

class Coupons_model extends CI_Model {

		function __construct() {
// Call the Model constructor
				parent :: __construct();
		}

		function getAllCoupons(){

			return $this->db->get('pt_coupons')->result();
		}

// add coupon
		function addCoupon() {
			


			$startdate = $this->input->post('startdate');
			$expdate = $this->input->post('expdate');

				if(empty($startdate) || empty($expdate)){

				$forever = 'Yes';

				}else{

				$forever = 'No';

				}

			    $maxuses = $this->input->post('max');
			    
			    if(empty($maxuses)){
			    	$maxuses = 0;
			    }

				$data = array(
					'code' => $this->input->post('code'), 
					'value' => $this->input->post('rate'), 
					'startdate' => convert_to_unix($startdate), 
					'expirationdate' => convert_to_unix($expdate), 
					'maxuses' => $maxuses,
					'forever' => $forever,
					'status' => $this->input->post('status')

					);

				$this->db->insert('pt_coupons', $data);

				$couponid = $this->db->insert_id();
				return $couponid;
		}

//udpate coupon
		function updateCoupon($couponid) {
				
			$startdate = $this->input->post('startdate');
			$expdate = $this->input->post('expdate');

				if(empty($startdate) || empty($expdate)){

				$forever = 'Yes';

				}else{

				$forever = 'No';

				}

			    $maxuses = $this->input->post('max');

				$data = array(
					'value' => $this->input->post('rate'), 
					'startdate' => convert_to_unix($startdate), 
					'expirationdate' => convert_to_unix($expdate), 
					'maxuses' => $maxuses,
					'forever' => $forever,
					'status' => $this->input->post('status')

					);

				$this->db->where('id', $couponid);
				$this->db->update('pt_coupons', $data);
		}


		function delete_coupon($id) {
				$this->db->where('id', $id);
				$this->db->delete('pt_coupons');

				$this->db->where('couponid',$id);
				$this->db->delete('pt_coupons_assign');

		}

		function validatecoupon($coupon) {
				$this->db->where('coupon_code', $coupon);
				$this->db->where('coupon_status', '1');
				$res = $this->db->get('pt_coupons')->result();
				return $res[0]->coupon_rate;
		}

		function assignCoupon($couponid, $items){
			

			if(!empty($items)){
			$this->db->where('couponid',$couponid);
			$this->db->delete('pt_coupons_assign');
			foreach($items as $item => $val){

			foreach($val as $v){

				$result[] = array("module" => $item, "item" => $v);
			}	
			

			}


			foreach($result as $r){
				$data = array(
					'couponid' => $couponid,
					'module' => $r['module'],
					'item' => $r['item']
					);
				$this->db->insert('pt_coupons_assign',$data);
			}
			
			

			}


		}

		

		function assignCouponToAllModules($couponid, $modules, $items){	

		if(!empty($items)){
			
			$this->assignCoupon($couponid,$items);
		}		

			if(!empty($modules)){
			$this->db->where('couponid',$couponid);
			$this->db->where('item','all');
			$this->db->delete('pt_coupons_assign');

			foreach($modules as $module){
			
				$data = array(
				'couponid' => $couponid,
				'module' => $module,
				'item' => 'all'

				);

				$this->db->insert('pt_coupons_assign',$data);


				$result[] = array("module" => $item, "item" => $v);
			

			}
			
			}

		}

}