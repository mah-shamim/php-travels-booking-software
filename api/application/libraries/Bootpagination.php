<?php

class Bootpagination {
/**
* Protected variables
*/
		protected $CI;

		function __construct() {
//get the CI instance
				$this->CI = & get_instance();
				$this->CI->load->library('pagination');
		}

		function dopagination($info) {

                $base = $info['base'];
                $urisegment = $info['urisegment'];
                $totalrows = $info['totalrows'];
                $perpage = $info['perpage'];
				$config['base_url'] = site_url($base);
				
				if(!empty($urisegment)){
					
				 $config['uri_segment'] = $urisegment;
				}

				if (count($_GET) > 0)
				$config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
				$config['total_rows'] = $totalrows;
				$config['per_page'] = $perpage;
				$config['num_links'] = 20;
				$config['use_page_numbers'] = TRUE;
				$config['full_tag_open'] = ''; 
				$config['full_tag_close'] = '';
				$config['first_link'] = '<i class="glyphicon-chevron-right la la-angle-right"></i>'; // &raquo; &laquo; First
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = '<i class="glyphicon-chevron-right la la-angle-left"></i>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = '<i class="glyphicon-chevron-right la la-angle-right"></i>';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = '<i class="glyphicon-chevron-right la la-angle-left"></i>';
				$config['prev_tag_open'] = '<li>';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['display_prev_link'] = TRUE;
				$config['display_next_link'] = TRUE;
				$this->CI->pagination->initialize($config);
				$html = $this->CI->pagination->create_links();
				return $html;
		}

}