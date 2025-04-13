<?php

class Supplier_accounts_model extends CI_Model {

		function __construct() {
// Call the Model constructor
				parent :: __construct();
		}

		function supplier_dashboard_stats($user) {
				$sdata = array();
				$this->db->select('hotel_id');
				$this->db->where('hotel_owned_by', $user);
				$sdata['hotels'] = $this->db->get('pt_hotels')->num_rows();
				$this->db->select('tour_id');
				$this->db->where('tour_owned_by', $user);
				$sdata['tours'] = $this->db->get('pt_tours')->num_rows();
				$sdata['extras'] = $this->my_sups_count($user);
				$sdata['reviews'] = $this->my_reveiws_count($user);
				return $sdata;
		}

		function my_sups_count($userid) {
				$ids = array();
				$this->db->select('hotel_id');
				$this->db->where('hotel_owned_by', $userid);
				$rs = $this->db->get('pt_hotels')->result();
				foreach ($rs as $r) {
						array_push($ids, $r->hotel_id);
				}
				if (!empty ($ids)) {
						foreach ($ids as $id) {
								$this->db->or_like('extras_for', $id, 'both');
						}
				}
				return $this->db->get('pt_extras')->num_rows();
		}

		function my_thingstodo_count($userid) {
				$ids = array();
				$this->db->select('hotel_id');
				$this->db->where('hotel_owned_by', $userid);
				$rs = $this->db->get('pt_hotels')->result();
				foreach ($rs as $r) {
						array_push($ids, $r->hotel_id);
				}
		}

		function my_reveiws_count($userid) {
				$ids = array();
				$this->db->select('hotel_id');
				$this->db->where('hotel_owned_by', $userid);
				$rs = $this->db->get('pt_hotels')->result();
				foreach ($rs as $r) {
						array_push($ids, $r->hotel_id);
				}
				if (!empty ($ids)) {
						foreach ($ids as $id) {
								$this->db->or_where('review_itemid', $id);
						}
				}
				$this->db->order_by('review_id', 'desc');
				return $this->db->get('pt_reviews')->num_rows();
		}

}