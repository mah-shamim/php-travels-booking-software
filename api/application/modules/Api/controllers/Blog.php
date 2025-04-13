<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Blog extends REST_Controller {

        function __construct() {
// Construct our parent class
                parent :: __construct();
//                if(!$this->isValidApiKey){
//                $this->response($this->invalidResponse, 400);
//               }
                $this->load->model("Api/Apiblog_model");
        }

        function list_get() {
                $offset = $this->get('offset');
                $perpage = $this->get('threshold');
                $list = $this->Apiblog_model->get_post($offset,$perpage);

                if (!empty ($list)) {
                      $this->response(array('response' => $list, 'error' => array('status' => FALSE,'msg' => '')), 200);
                }
                else {
                    	$this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Posts Not found')), 200);
                }
        }

        function detail_get() {
                $id = $this->get('id');
                $res = $this->Apiblog_model->post_details($id);
                $message = array('response' => $res);
                $this->response($message, 200); // 200 being the HTTP response code
        }

        function show_get() {
                $url = base_url() . "api/blog/list";
                $ch = curl_init();
                $timeout = 3;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $rawdata = curl_exec($ch);
                curl_close($ch);
                @ $json = json_decode($rawdata);
                echo "<pre>";
                print_r($json);
        }

        function chkpost_get() {
                $url = base_url() . "api/contact/send";
                $fields = array('contact_name' => 'JohnDue ali jan', 'contact_email' => 'mail@example.com', 'contact_subject' => "this is subject", 'contact_message' => "This is the message", 'sendto' => "sendto@email.com");
//url-ify the data for the POST
                foreach ($fields as $key => $value) {
                        $fields_string .= $key . '=' . $value . '&';
                }
                rtrim($fields_string, '&');
                $ch = curl_init();
                $timeout = 3;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $rawdata = curl_exec($ch);
                curl_close($ch);
                @ $json = json_decode($rawdata);
                echo "<pre>";
                print_r($json);
        }

}
