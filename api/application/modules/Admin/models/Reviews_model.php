<?php

class Reviews_model extends CI_Model {

		function __construct() {
// Call the Model constructor
				parent :: __construct();
		}

		function add_review() {
				$reviewforid = $this->input->post('reviews_for_id');
				$reviewdate = $this->input->post('reviewsdate');
				$data = array('review_name' => $this->input->post('reviews_name'),'review_email' => $this->input->post('reviews_email'), 'review_comment' => $this->input->post('reviews_comments'), 'review_module' => $this->input->post('reviewmodule'), 'review_itemid' => $reviewforid, 'review_date' => convert_to_unix($reviewdate), 'review_clean' => $this->input->post('reviews_clean'), 'review_staff' => $this->input->post('reviews_staff'), 'review_facilities' => $this->input->post('reviews_facilities'), 'review_location' => $this->input->post('reviews_location'), 'review_comfort' => $this->input->post('reviews_comfort'), 'review_overall' => $this->input->post('overall'), 'review_status' => $this->input->post('reviewstatus'));
				$this->db->insert('pt_reviews', $data);
		}

//udpate review
		function update_review($id) {
				$reviewforid = $this->input->post('reviews_for_id');
				$reviewdate = $this->input->post('reviewsdate');
				$data = array('review_name' => $this->input->post('reviews_name'), 'review_email' => $this->input->post('reviews_email'),'review_comment' => $this->input->post('reviews_comments'), 'review_module' => $this->input->post('reviewmodule'), 'review_itemid' => $reviewforid, 'review_date' => convert_to_unix($reviewdate), 'review_clean' => $this->input->post('reviews_clean'), 'review_staff' => $this->input->post('reviews_staff'), 'review_facilities' => $this->input->post('reviews_facilities'), 'review_location' => $this->input->post('reviews_location'), 'review_comfort' => $this->input->post('reviews_comfort'), 'review_overall' => $this->input->post('overall'), 'review_status' => $this->input->post('reviewstatus'));
				$this->db->where('review_id', $id);
				$this->db->update('pt_reviews', $data);
		}

// add review by customer
		function add_review_cust($status) {
				$data = array('review_booking_id' => $this->input->post('bookingid'),
					'review_user' => $this->input->post('userid'),
					'review_email' => $this->input->post('email'),
					'review_name' => $this->input->post('fullname'),
					'review_comment' => $this->input->post('reviews_comments'),
					'review_module' => $this->input->post('reviewmodule'),
					'review_itemid' => $this->input->post('reviewfor'),
					'review_date' => time(),
					'review_clean' => $this->input->post('reviews_clean'),
					'review_staff' => $this->input->post('reviews_staff'), 'review_facilities' => $this->input->post('reviews_facilities'), 'review_location' => $this->input->post('reviews_location'), 'review_comfort' => $this->input->post('reviews_comfort'), 'review_overall' => $this->input->post('overall'), 'review_status' => $status);
				$this->db->insert('pt_reviews', $data);
		}

// add review by public
		function add_review_public($status) {
			  $facilities = $this->input->post('reviews_facilities');
				if(empty($facilities)){
					$facilities = 1;
				}

				$location = $this->input->post('reviews_location');
				if(empty($location)){
					$location = 1;
				}

				$comfort = $this->input->post('reviews_comfort');
				if(empty($comfort)){
					$comfort = 1;
				}

				$overall =  $this->input->post('overall');
				if(empty($overall)){
					$overall = 1;
				}

				$staff = $this->input->post('reviews_staff');
				if(empty($staff)){
					$staff = 1;
				}

				$clean = $this->input->post('reviews_clean');
				if(empty($clean)){
					$clean = 1;
				}

				$data = array('review_name' => $this->input->post('fullname'), 'review_comment' => $this->input->post('reviews_comments'),
				'review_module' => $this->input->post('reviewmodule'), 'review_itemid' => $this->input->post('reviewfor'),
				'review_date' => time(), 'review_clean' => $clean,
				'review_staff' => $staff,
				'review_facilities' => $facilities,
				'review_location' => $location,
				'review_comfort' => $comfort,
				'review_overall' => $overall,
				'review_email' => $this->input->post('email'), 'review_status' => $status);
				$this->db->insert('pt_reviews', $data);
		}

// update review by Admin
		function update_review_admin($id) {
				$data = array('review_name' => $this->input->post('fullname'), 'review_comment' => $this->input->post('reviews_comments'), 'review_clean' => $this->input->post('reviews_clean'), 'review_staff' => $this->input->post('reviews_staff'), 'review_facilities' => $this->input->post('reviews_facilities'), 'review_location' => $this->input->post('reviews_location'), 'review_comfort' => $this->input->post('reviews_comfort'), 'review_overall' => $this->input->post('overall'), 'review_email' => $this->input->post('email'));
				$this->db->where('review_id', $id);
				$this->db->update('pt_reviews', $data);
		}

		function check_already_review_posted($email, $id, $module) {
				$this->db->select('review_id');
				$this->db->where('review_itemid', $id);
				$this->db->where('review_email', $email);
				$this->db->where('review_module', $module);
				$rows = $this->db->get('pt_reviews')->num_rows;
				if ($rows > 0) {
						return true;
				}
				else {
						return false;
				}
		}

// get all reviews
		function get_all_reviews() {
				$this->db->order_by('review_id', 'desc');
				return $this->db->get('pt_reviews')->result();
		}

// get all data of single Supplement
		function get_review_data($id) {
				$this->db->where('review_id', $id);
				return $this->db->get('pt_reviews')->result();
		}
// Disable Review

		public function disable_review($id) {
				$data = array('review_status' => '0');
				$this->db->where('review_id', $id);
				$this->db->update('pt_reviews', $data);
		}
// Enable Review

		public function approveReview() {
			$id = $this->input->post('id');
				$data = array('review_status' => 'Yes');
				$this->db->where('review_id', $id);
				$this->db->update('pt_reviews', $data);
		}

		function delete_review($id) {
				$this->db->where('review_id', $id);
				$this->db->delete('pt_reviews');
		}

		function count_pending_reviews($module) {
				$this->db->where('review_module', $module);
				$this->db->where('review_status', '0');
				return $this->db->get('pt_reviews')->num_rows();
		}

}
