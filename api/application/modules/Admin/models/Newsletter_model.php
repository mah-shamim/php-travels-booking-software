<?php

class Newsletter_model extends CI_Model {

		function __construct() {
// Call the Model constructor
				parent :: __construct();
		}

// get all subscribers
		function get_all_subscribers() {
				return $this->db->get('pt_newsletter')->result();
		}

// add to subscription list
		function add_subscriber($email, $type = "subscribers") {
				$issubscribed = $this->is_subscribed($email);
				if (!$issubscribed) {
						$data = array('newsletter_subscribers' => $email, 'newsletter_type' => $type);
						$this->db->insert('pt_newsletter', $data);
						return true;
				}
				else {
						return false;
				}
		}

// remove from subscription list
		function remove_subscriber($email) {
				$issubscribed = $this->is_subscribed($email);
				if ($issubscribed) {
						$this->db->where('newsletter_subscribers', $email);
						$this->db->delete('pt_newsletter');
						return true;
				}
				else {
						return false;
				}
		}

// Enable Subscriber
		function enable_subscriber($id) {
				$data = array('newsletter_status' => 'Yes');
				$this->db->where('newsletter_id', $id);
				$this->db->update('pt_newsletter', $data);
		}

// Disable Subscriber
		function disable_subscriber($id) {
				$data = array('newsletter_status' => '0');
				$this->db->where('newsletter_id', $id);
				$this->db->update('pt_newsletter', $data);
		}

// Disable Subscriber
		function delete_subscriber($id) {
				$this->db->where('newsletter_id', $id);
				$this->db->delete('pt_newsletter');
		}

// check email if subscribed or not
		function is_subscribed($email) {
				$this->db->select('newsletter_subscribers');
				$this->db->where('newsletter_subscribers', $email);
				$q = $this->db->get('pt_newsletter')->num_rows();
				if ($q > 0) {
						return true;
				}
				else {
						return false;
				}
		}

		public function render($context, $post) {
				return preg_replace_callback('/{(.*?)}/',

				function ($v) use ($context) {
						return isset ($context[$v[1]]) ? $context[$v[1]] : '';
				}
				, $post );
		}

		function sendNewsletter($message, $subject) {
				$this->load->model('Admin/Emails_model');
				$type = $this->input->post('sendto');
				if ($type != "everyone") {
						$emails = $this->get_emails($type);
						foreach ($emails as $e) {
								if ($type == "subscribers") {
										$sender = $e->newsletter_subscribers;
								}
								else {
										$sender = $e->accounts_email;
								}
								$this->Emails_model->sendNewsletter($message, $subject, $sender);
						}
				}
				else {
						$newsemails = $this->get_all_emails();
						foreach ($newsemails as $eall) {
								$this->Emails_model->sendNewsletter($message, $subject, $eall);
						}
				}
		}

		function get_emails($type) {
			  if ($type == 'customers') {
						return $this->get_customers_emails();
				}
				elseif ($type == 'subscribers') {
						return $this->get_subscribers_emails();
				}
				elseif ($type == 'guest') {
						return $this->get_guest_emails();
				}
				elseif ($type == 'admin') {
						return $this->get_admin_emails();
				}			
				elseif ($type == 'supplier') {
						return $this->get_supplier_emails();
				}
		}

		function get_all_emails() {
				$emails = array();
				$this->db->select('accounts_email,accounts_status');
				$this->db->where('accounts_status', 'yes');
				$e = $this->db->get('pt_accounts')->result();
				foreach ($e as $em) {
						$ae = $em->accounts_email;
						array_push($emails, $ae);
				}
				$this->db->select('newsletter_subscribers,newsletter_status');
				$this->db->where('newsletter_status', 'Yes');
				$sube = $this->db->get('pt_newsletter')->result();
				foreach ($sube as $sem) {
						$ns = $sem->newsletter_subscribers;
						if(!in_array($ns,$emails)){
							array_push($emails, $ns);	
						}
						
				}
				return $emails;
		}

		function get_subscribers_emails() {
				$this->db->select('newsletter_subscribers,newsletter_status');
				$this->db->where('newsletter_status', 'Yes');
				$e = $this->db->get('pt_newsletter')->result();
				return $e;
		}

		function get_customers_emails() {
				$this->db->select('accounts_email,accounts_status');
				$this->db->where('accounts_status', 'yes');
				$this->db->where('accounts_type', 'customers');
				$e = $this->db->get('pt_accounts')->result();
				return $e;
		}

		function get_suppliers_emails() {
				$this->db->select('accounts_email,accounts_status');
				$this->db->where('accounts_status', 'yes');
				$this->db->where('accounts_type', 'suppliers');
				$e = $this->db->get('pt_accounts')->result();
				return $e;
		}

		function get_supplier_emails() {
				$this->db->select('accounts_email,accounts_status');
				$this->db->where('accounts_status', 'yes');
				$this->db->where('accounts_type', 'supplier');
				$e = $this->db->get('pt_accounts')->result();
				return $e;
		}

		function get_admin_emails() {
				$this->db->select('accounts_email,accounts_status');
				$this->db->where('accounts_status', 'yes');
				$this->db->where('accounts_type', 'admin');
				$e = $this->db->get('pt_accounts')->result();
				return $e;
		}

		function get_guest_emails() {
				$this->db->select('accounts_email,accounts_status');
				$this->db->where('accounts_status', 'yes');
				$this->db->where('accounts_type', 'guest');
				$this->db->group_by('accounts_email');
				$e = $this->db->get('pt_accounts')->result();
				return $e;
		}

}