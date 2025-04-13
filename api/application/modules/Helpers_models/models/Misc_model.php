<?php

class Misc_model extends CI_Model {
		public $langdef;

		function __construct() {
// Call the Model constructor
				parent :: __construct();
				$this->langdef = DEFLANG;
		}

/******************** Socialize  ***********************************/
		function get_all_header_social() {
				$this->db->where('social_status', 'Yes');
				$this->db->where('social_position', 'both');
				$this->db->or_where('social_position', 'header');
				$this->db->order_by('social_order', 'asc');
				$q = $this->db->get('pt_socials')->result();
				return $q;
		}

		function get_all_footer_social() {
				$this->db->having('social_status', 'Yes');
				$this->db->where('social_position', 'both');
				$this->db->or_where('social_position', 'footer');
				$this->db->order_by('social_order', 'asc');
				$q = $this->db->get('pt_socials')->result();
				return $q;
		}

		function get_all_socials() {
				$this->db->order_by('social_id', 'desc');
				$q['all'] = $this->db->get('pt_socials')->result();
				$q['nums'] = $this->db->get('pt_socials')->num_rows();
				return $q;
		}

// Add social network
		function addsocial($filename) {
				$counts = $this->db->get('pt_socials')->num_rows();
				$order = $counts + 1;
				$data = array('social_name' => $this->input->post('conn_name'), 'social_link' => $this->input->post('link'), 'social_status' => $this->input->post('conn_status'), 'social_position' => $this->input->post('position'), 'social_order' => $order, 'social_icon' => $filename);
				$this->db->insert('pt_socials', $data);
		}

// Update social network
		function update_social($id, $filename = null) {
				$oldpic = $this->input->post('oldphoto');
				if ($filename != null) {
						$filename = $filename;
				}
				else {
						$filename = $oldpic;
				}
				$data = array('social_name' => $this->input->post('conn_name'), 'social_link' => $this->input->post('link'), 'social_status' => $this->input->post('conn_status'), 'social_position' => $this->input->post('position'), 'social_icon' => $filename);
				$this->db->where('social_id', $id);
				$this->db->update('pt_socials', $data);
		}

// Delete social network
		function delete_social($id) {
				$this->db->where('social_id', $id);
				$res = $this->db->get('pt_socials')->result();
				$img = $res[0]->social_icon;
				unlink('images/upload/social/' . $img);
				$this->db->where('social_id', $id);
				$this->db->delete('pt_socials');
		}
// Disable Social network

		public function disable_social($id) {
				$data = array('social_status' => 'No');
				$this->db->where('social_id', $id);
				$this->db->update('pt_socials', $data);
		}
// Enable Social network

		public function enable_social($id) {
				$data = array('social_status' => 'Yes');
				$this->db->where('social_id', $id);
				$this->db->update('pt_socials', $data);
		}
// update Social order

		public function update_social_order($id, $order) {
				$data = array('social_order' => $order);
				$this->db->where('social_id', $id);
				$this->db->update('pt_socials', $data);
		}

/******************** End Socialize  ***********************************/
/******************** Sliders Section  ***********************************/
// Add Slide
		function addslide($filename) {
				$counts = $this->db->get('pt_sliders')->num_rows();
				$order = $counts + 1;
				$data = array(
//      'slide_position' => $this->input->post('slide_position'),
				'slide_link' => $this->input->post('slide_link'), 'slide_optional_text' => $this->input->post('slide_optional'), 'slide_title_text' => $this->input->post('slide_title'), 'slide_desc_text' => $this->input->post('slide_desc'), 'slide_link_name' => $this->input->post('slide_button'), 'slide_status' => $this->input->post('slide_status'), 'slide_order' => $order, 'slide_image' => $filename);
				$this->db->insert('pt_sliders', $data);
		}

// Update Slide Data
		function updateslider_data($id, $filename = null) {
				$oldpic = $this->input->post('oldphoto');
				if ($filename != null) {
						$filename = $filename;
				}
				else {
						$filename = $oldpic;
				}
				$data = array(
//    'slide_position' => $this->input->post('slide_position'),
				'slide_link' => $this->input->post('slide_link'), 'slide_optional_text' => $this->input->post('slide_optional'), 'slide_title_text' => $this->input->post('slide_title'), 'slide_desc_text' => $this->input->post('slide_desc'), 'slide_link_name' => $this->input->post('slide_button'), 'slide_status' => $this->input->post('slide_status'), 'slide_image' => $filename);
				$this->db->where('slide_id', $id);
				$this->db->update('pt_sliders', $data);
		}

// Get All Slides
		function get_all_slides() {
				$this->db->order_by('slide_order', 'asc');
				$q['all'] = $this->db->get('pt_sliders')->result();
				$q['nums'] = $this->db->get('pt_sliders')->num_rows();
				return $q;
		}

// Get All main slides data
		function get_all_main_slides() {
				$this->db->order_by('slide_order', 'asc');
				$this->db->where('slide_position', 'main');
				$this->db->where('slide_status', 'Yes');
				$q = $this->db->get('pt_sliders')->result();
				return $q;
		}

// Delete Slide
		function delete_slide($id) {
				$this->db->select('slide_image');
				$this->db->where('slide_id', $id);
				$res = $this->db->get('pt_sliders')->result();
				unlink(PT_SLIDER_IMAGES_UPLOAD_THUMBS . $res[0]->slide_image);
				unlink(PT_SLIDER_IMAGES_UPLOAD . $res[0]->slide_image);
				$this->db->where('slide_id', $id);
				$this->db->delete('pt_sliders');
		}
// Disable Slide

		public function disable_slide($id) {
				$data = array('slide_status' => 'No');
				$this->db->where('slide_id', $id);
				$this->db->update('pt_sliders', $data);
		}
// Enable Slide

		public function enable_slide($id) {
				$data = array('slide_status' => 'Yes');
				$this->db->where('slide_id', $id);
				$this->db->update('pt_sliders', $data);
		}
// update slides order

		public function update_slide_order($id, $order) {
				$data = array('slide_order' => $order);
				$this->db->where('slide_id', $id);
				$this->db->update('pt_sliders', $data);
		}

// slider translations functions
// update translated data os some fields in english
		function update_english($id) {
				$data = array('slide_title_text' => $this->input->post('title'), 'slide_desc_text' => $this->input->post('desc'));
				$this->db->where('slide_id', $id);
				$this->db->update('pt_sliders', $data);
		}

// Adds translation of some fields data
		function add_translation($language, $slideid) {
				$title = $this->input->post('title');
				$desc = $this->input->post('desc');
				$data = array('trans_title' => $title, 'trans_desc' => $desc, 'item_id' => $slideid, 'trans_lang' => $language,);
				$this->db->insert('pt_sliders_translation', $data);
				$this->session->set_flashdata('flashmsgs', 'Changes Saved');
		}

// Update translation of some fields data
		function update_translation($lang) {
				if ($lang == $this->langdef) {
						$slideid = $this->input->post('slideid');
						$slug = $this->update_english($slideid);
				}
				else {
						$id = $this->input->post('transid');
						$title = $this->input->post('title');
						$desc = $this->input->post('desc');
						$data = array('trans_title' => $title, 'trans_desc' => $desc);
						$this->db->where('trans_id', $id);
						$this->db->update('pt_sliders_translation', $data);
				}
				$this->session->set_flashdata('flashmsgs', 'Changes Saved');
				return $slug;
		}

/******************** End Sliders Section  ***********************************/
/******************** Pending Images Section  ***********************************/
		function count_pending_hotel_images() {
				$this->db->where('himg_approved', '0');
				return $this->db->get('pt_hotel_images')->num_rows();
		}


		function count_pending_room_images() {
				$this->db->where('rimg_approved', '0');
				return $this->db->get('pt_room_images')->num_rows();
		}

		function count_pending_tour_images() {
				$this->db->where('timg_approved', '0');
				return $this->db->get('pt_tour_images')->num_rows();
		}

		function count_pending_car_images() {
				$this->db->where('cimg_approved', '0');
				return $this->db->get('pt_car_images')->num_rows();
		}

		function count_pending_cruise_images() {
				$this->db->where('cimg_approved', '0');
				return $this->db->get('pt_cruise_images')->num_rows();
		}

		function count_pending_croom_images() {
				$this->db->where('rimg_approved', '0');
				return $this->db->get('pt_cruise_room_images')->num_rows();
		}

		function count_pending_accounts_cust() {
				$this->db->where('accounts_status', '0');
				$this->db->where('accounts_type', 'customers');
				return $this->db->get('pt_accounts')->num_rows();
		}

		function count_pending_accounts_supplier() {
				$this->db->where('accounts_status', '0');
				$this->db->where('accounts_type', 'suppliers');
				return $this->db->get('pt_accounts')->num_rows();
		}
/******************** End Pending Images Section  ***********************************/

}