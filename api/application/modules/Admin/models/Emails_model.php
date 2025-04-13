<?php
class Emails_model extends CI_Model {
		private $sendfrom;
		private $adminemail;
		private $adminmobile;
		private $sitetitle;
		private $siteurl;
		private $mailHeader;
		private $mailFooter;

		function __construct() {
// Call the Model constructor
				parent :: __construct();
				$this->adminemail = $this->get_admin_email();
				$this->adminmobile = $this->get_admin_mobile();
				$siteInfo = $this->get_siteTitleUrl();
				$this->sitetitle = $siteInfo['title'];
				$this->siteurl = addHttp($siteInfo['url']);

				$headFootShortcode = array("{siteTitle}","{siteUrl}");
				$headFootVals = array($this->sitetitle,$this->siteurl);

				$mailsettings = $this->get_mailserver();
				$this->mailHeader = str_replace($headFootShortcode, $headFootVals, $mailsettings[0]->mail_header);
				$this->mailFooter = str_replace($headFootShortcode, $headFootVals, $mailsettings[0]->mail_footer);
				
				if ($mailsettings[0]->mail_default == "smtp") {
					
					if($mailsettings[0]->mail_secure == "no"){
						$secure = "";
					}else{
						$secure = $mailsettings[0]->mail_secure."://";
					}
						$this->sendfrom = $mailsettings[0]->mail_fromemail;
						$config = Array('protocol' => 'smtp', 'charset' => 'utf-8',
							'smtp_host' => $secure.$mailsettings[0]->mail_hostname, 
							'smtp_port' => $mailsettings[0]->mail_port, 
							'smtp_user' => $mailsettings[0]->mail_username, 'smtp_pass' => $mailsettings[0]->mail_password, 'mailtype' => 'html', 'charset' => 'iso-8859-1', 'wordwrap' => TRUE,'smtp_auth' => TRUE);
						$this->load->library('email', $config);
				}
				else {
						$this->sendfrom = $mailsettings[0]->mail_fromemail;
						$this->load->library('email');
						$this->email->set_mailtype("html");
				}
				
		}

		function sendtestemail($toemail) {
				$this->email->set_newline("\r\n");
				$message = $this->mailHeader;
				$message .= $this->sendfrom." --this is test email <br>";
				$message .= $this->mailFooter;
				$this->email->from($this->sendfrom);
				$this->email->to($toemail);
				$this->email->subject('tesing email server');
				$this->email->message($message);
				if (!$this->email->send()) {
						echo $this->email->print_debugger();
				}
				else {
						echo 'Email sent';
				}
		}


//send email to customer

    function send_customeremail($data){
        $currencycode = '';
        $currencysign = '';
        $custid = '';
        $country = '';
        $name = '';
        $phone = '';
        $paymethod = '';
        $invoiceid = $data[0]->booking_id;
        $refno = $data[0]->booking_ref_no;
        $totalamount = '';
        $deposit = '';
        $duedate = '';
        $date = '';
        $sendto = $data[0]->accounts_email;
        $invoicelink = $data[0]->invoice_url;
        $template = $this->shortcode_variables("bookingordercustomer");
        $details = email_template_detail("bookingordercustomer");
        //$smsdetails = sms_template_detail("bookingordercustomer");
        $values = array($invoiceid, $refno, $deposit, $totalamount, $sendto, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, '', $duedate, $name);
        $message = $this->mailHeader;
        $message .= str_replace($template, $values, $details[0]->temp_body);
        $message .= $this->mailFooter;

        // SMS Notification
        $template = get_sms_template(8); // booking order customer
        $smsmessage = str_replace(explode(' ', $template->shortcode), $values, $template->body);
        $this->load->library('Sms_notification');
        $smsNotification = new Sms_notification();
        $smsNotification->recepient = $phone;
        $smsNotification->message   = strip_tags($smsmessage);
        $response = $smsNotification->send();
        //$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
        //sendsms($smsmessage, $phone, "bookingordercustomer");
        $this->email->set_newline("\r\n");
        $this->email->from($this->sendfrom);
        $this->email->to($sendto);
        $this->email->subject($details[0]->temp_subject);
        $this->email->message($message);
        $this->email->send();

    }

		function sendEmail_customer($details, $sitetitle) {
			$currencycode = $details->currCode;
			$currencysign = $details->currSymbol;
				$custid = $details->bookingUser;
				$country = $details->userCountry;
				$name = $details->userFullName;
				$phone = $details->userMobile;
				$paymethod = $details->paymethod;
				$invoiceid = $details->id;
				$refno = $details->code;
				$totalamount = $details->checkoutTotal;
				$deposit = $details->checkoutAmount;
				$duedate = $details->expiry;
				$date = $details->date;
				$sendto = $details->accountEmail;
				$invoicelink = "<a href=" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . " >" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . "</a>";
				$template = $this->shortcode_variables("bookingordercustomer");
				$details = email_template_detail("bookingordercustomer");
				//$smsdetails = sms_template_detail("bookingordercustomer");
				$values = array($invoiceid, $refno, $deposit, $totalamount, $sendto, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, $sitetitle, $duedate, $name);
				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				// SMS Notification
				$template = get_sms_template(8); // booking order customer
				$smsmessage = str_replace(explode(' ', $template->shortcode), $values, $template->body);
				$this->load->library('Sms_notification');
                $smsNotification = new Sms_notification();
				$smsNotification->recepient = $phone;
				$smsNotification->message   = strip_tags($smsmessage);
				$response = $smsNotification->send();
				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $phone, "bookingordercustomer");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($sendto);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
		}

//send email to Admin

//send email to Admin
    function send_adminemail($data) {
        $currencycode = '';
        $currencysign = '';
        $custid = '';
        $country = '';
        $name = '';
        $phone = '';
        $paymethod = '';
        $invoiceid = $data[0]->booking_id;
        $refno = $data[0]->booking_ref_no;
        $totalamount = '';
        $deposit = '';
        $duedate = '';
        $date = '';
        $custemail = $data[0]->accounts_email;
        $sendto = $this->adminemail;
        $invoicelink = $data[0]->invoice_url;
        $template = $this->shortcode_variables("bookingorderadmin");
        $details = email_template_detail("bookingorderadmin");
        //$smsdetails = sms_template_detail("bookingorderadmin");
        $values = array($invoiceid, $refno, $deposit, $totalamount, $custemail, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, '', $name);

        $message = $this->mailHeader;
        $message .= str_replace($template, $values, $details[0]->temp_body);
        $message .= $this->mailFooter;


        //$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
        //sendsms($smsmessage, $this->adminmobile, "bookingorderadmin");
        $this->email->set_newline("\r\n");
        $this->email->from($this->sendfrom);
        $this->email->to($sendto);
        $this->email->subject($details[0]->temp_subject);
        $this->email->message($message);
        $this->email->send();
    }

		function sendEmail_admin($details, $sitetitle) {
				$currencycode = $details->currCode;
			 $currencysign = $details->currSymbol;

			    $custid = $details->bookingUser;
				$country = $details->userCountry;
				$name = $details->userFullName;
				$phone = $details->userMobile;
				$paymethod = $details->paymethod;
				$invoiceid = $details->id;
				$refno = $details->code;
				$totalamount = $details->checkoutTotal;
				$deposit = $details->checkoutAmount;
				$duedate = $details->expiry;
				$date = $details->date;
				$custemail = $details->accountEmail;
				$sendto = $this->adminemail;
				$invoicelink = "<a href=" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . " >" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . "</a>";
				$template = $this->shortcode_variables("bookingorderadmin");
				$details = email_template_detail("bookingorderadmin");
				//$smsdetails = sms_template_detail("bookingorderadmin");
				$values = array($invoiceid, $refno, $deposit, $totalamount, $custemail, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, $sitetitle, $name);
				
				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				
				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $this->adminmobile, "bookingorderadmin");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($sendto);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
		}

//send email to Owner
		function sendEmail_owner($details, $sitetitle) {

			 $currencycode = $details->currCode;
			 $currencysign = $details->currSymbol;

			 $custid = $details->bookingUser;
				$country = $details->userCountry;
				$name = $details->userFullName;
				$phone = $details->userMobile;
				$paymethod = $details->paymethod;
				$invoiceid = $details->id;
				$refno = $details->code;
				$totalamount = $details->checkoutTotal;
				$deposit = $details->checkoutAmount;
				$duedate = $details->expiry;
				$date = $details->date;
				$custemail = $details->accountEmail;

				$sendto = $this->ownerEmail($details->module, $details->itemid);

				$message = $this->mailHeader;
				$message .= "<h4><b>Order Information</b></h4>";
				$message .= "Date :" . $date . ".<br>";
				$message .= "Invoice No.: " . $invoiceid . ".<br>";
			//	$message .= "Payment Method: " . $paymethod . ".<br><br>";
				$message .= "Deposit Amount: " . $currencycode . " " . $currencysign . $deposit . "<br>";
				$message .= "Total Amount: " . $currencycode . " " . $currencysign . $totalamount . "<br><br>";
				$message .= "<h4><b>Customer Information</b></h4>";
				$message .= "Customer ID: " . $custid . "<br>";
				$message .= "Name : " . $name . "<br>";
				$message .= "Email : " . $custemail . "<br>";
				if(!empty($country)){
				$message .= "Country : " . $country . "<br>";	
				}
				
				$message .= "Phone : " . $phone . "<br>";
				$message .= "<br> To view Invoice visit at: <a href=" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . " >" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . "</a>";
				$message .= $this->mailFooter;

				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($sendto);
				$this->email->subject('New Booking Notification');
				$this->email->message($message);
				$this->email->send();
		}
		// Global Mail send

    function globalmail($parm) {
        $sendto = $parm['email'];
        $message = $this->mailHeader;
        $message .= $parm['body'];
        $message .= $this->mailFooter;
        $this->email->set_newline("\r\n");
        $this->email->from($this->sendfrom);
        $this->email->to($sendto);
        $this->email->to($sendto);
        $this->email->cc($parm['cc_mail']);
        $this->email->subject($parm['subject']);
        $this->email->message($message);
        $this->email->send();

    }
//send email to Supplier

    function send_suppliermail($data) {
        $currencycode = '';
        $currencysign = '';
        $custid = '';
        $country = '';
        $name = '';
        $phone = '';
        $paymethod = '';
        $invoiceid = $data[0]->booking_id;
        $refno = $data[0]->booking_ref_no;
        $totalamount = '';
        $deposit = '';
        $duedate = '';
        $date = '';
        $custemail = $data[0]->accounts_email;
        $sendto = $this->supplierEmail($data['module'], $data[0]->hotel_id);
        $invoicelink = $data[0]->invoice_url;
        $template = $this->shortcode_variables("bookingordersupplier");
        $details = email_template_detail("bookingordersupplier");
        //$smsdetails = sms_template_detail("bookingorderadmin");
        $values = array($invoiceid, $refno, $deposit, $totalamount, $custemail, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, $sitetitle, $name);

        $message = $this->mailHeader;
        $message .= str_replace($template, $values, $details[0]->temp_body);
        $message .= $this->mailFooter;


        //$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
        //sendsms($smsmessage, $this->adminmobile, "bookingorderadmin");
        $this->email->set_newline("\r\n");
        $this->email->from($this->sendfrom);
        $this->email->to($sendto);
        $this->email->subject($details[0]->temp_subject);
        $this->email->message($message);
        $this->email->send();


    }
		function sendEmail_supplier($details, $sitetitle) {
			$currencycode = $details->currCode;
			 $currencysign = $details->currSymbol;

			    $custid = $details->bookingUser;
				$country = $details->userCountry;
				$name = $details->userFullName;
				$phone = $details->userMobile;
				$paymethod = $details->paymethod;
				$invoiceid = $details->id;
				$refno = $details->code;
				$totalamount = $details->checkoutTotal;
				$deposit = $details->checkoutAmount;
				$duedate = $details->expiry;
				$date = $details->date;
				$custemail = $details->accountEmail;
				$sendto = $this->supplierEmail($details->module, $details->itemid);
				$invoicelink = "<a href=" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . " >" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . "</a>";
				$template = $this->shortcode_variables("bookingordersupplier");
				$details = email_template_detail("bookingordersupplier");
				//$smsdetails = sms_template_detail("bookingorderadmin");
				$values = array($invoiceid, $refno, $deposit, $totalamount, $custemail, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, $sitetitle, $name);
				
				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				
				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $this->adminmobile, "bookingorderadmin");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($sendto);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();

			
		}

//send email to customer for booking payment success

    function paid_send_customeremail($data) {
        $currencycode = '';
        $currencysign = '';
        $custid = '';
        $country = '';
        $name = '';
        $phone = '';
        $paymethod = '';
        $invoiceid = $data[0]->booking_id;
        $refno = $data[0]->booking_ref_no;
        $totalamount = '';
        $deposit = '';
        $duedate = '';
        $date = '';
        $sendto = $data[0]->accounts_email;

        $remaining = '';
        $sitetitle = "";
        $invoicelink = $data[0]->invoice_url;
        $template = $this->shortcode_variables("bookingpaidcustomer");
        $details = email_template_detail("bookingpaidcustomer");
        //$smsdetails = sms_template_detail("bookingpaidcustomer");
        $values = array($invoiceid, $refno, $deposit, $totalamount, $sendto, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, $sitetitle, $remaining, $name);

        $message = $this->mailHeader;
        $message .= str_replace($template, $values, $details[0]->temp_body);
        $message .= $this->mailFooter;

        //$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
        //sendsms($smsmessage, $phone, "bookingpaidcustomer");
        $this->email->set_newline("\r\n");
        $this->email->from($this->sendfrom);
        $this->email->to($sendto);
        $this->email->subject($details[0]->temp_subject);
        $this->email->message($message);
        $this->email->send();
    }

		function paid_sendEmail_customer($details) {
			$currencycode = $details->currCode;
			$currencysign = $details->currSymbol;

				$custid = $details->bookingUser;
				$country = $details->userCountry;
				$name = $details->userFullName;
				$phone = $details->userMobile;
				$paymethod = $details->paymethod;
				$invoiceid = $details->id;
				$refno = $details->code;
				$totalamount = $details->checkoutTotal;
				$deposit = $details->checkoutAmount;
				$duedate = $details->expiry;
				$date = $details->date;
				$sendto = $details->accountEmail;

				$remaining = $details->remainingAmount;
				$sitetitle = "";

				$invoicelink = "<a href=" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . " >" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . "</a>";
				$template = $this->shortcode_variables("bookingpaidcustomer");
				$details = email_template_detail("bookingpaidcustomer");
				//$smsdetails = sms_template_detail("bookingpaidcustomer");
				$values = array($invoiceid, $refno, $deposit, $totalamount, $sendto, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, $sitetitle, $remaining, $name);
				
				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $phone, "bookingpaidcustomer");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($sendto);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
		}

//send email to Admin for booking paid

    function paid_send_adminemail($data) {

        $currencycode = '';
        $currencysign = '';
        $custid = '';
        $country = '';
        $name = '';
        $phone = '';
        $paymethod = '';
        $invoiceid = $data[0]->booking_id;
        $refno = $data[0]->booking_ref_no;
        $totalamount = '';
        $deposit = '';
        $duedate = '';
        $date = '';
        $custemail = $data[0]->accounts_email;
        $sendto = $this->adminemail;

        $sitetitle = "";

        $invoicelink = $data[0]->invoice_url;
        $template = $this->shortcode_variables("bookingpaidadmin");
        $details = email_template_detail("bookingpaidadmin");
        //$smsdetails = sms_template_detail("bookingpaidadmin");
        $values = array($invoiceid, $refno, $deposit, $totalamount, $custemail, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, $sitetitle, $name);

        $message = $this->mailHeader;
        $message .= str_replace($template, $values, $details[0]->temp_body);
        $message .= $this->mailFooter;

        //$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
        //sendsms($smsmessage, $this->adminmobile, "bookingpaidadmin");
        $this->email->set_newline("\r\n");
        $this->email->from($this->sendfrom);
        $this->email->to($sendto);
        $this->email->subject('Booking Payment Notification');
        $this->email->message($message);
        $this->email->send();
    }

		function paid_sendEmail_admin($details) {

			$currencycode = $details->currCode;
			$currencysign = $details->currSymbol;

				$custid = $details->bookingUser;
				$country = $details->userCountry;
				$name = $details->userFullName;
				$phone = $details->userMobile;
				$paymethod = $details->paymethod;
				$invoiceid = $details->id;
				$refno = $details->code;
				$totalamount = $details->checkoutTotal;
				$deposit = $details->checkoutAmount;
				$duedate = $details->expiry;
				$date = $details->date;
				$remaining = $details->remainingAmount;
				$custemail = $details->accountEmail;				
				$sendto = $this->adminemail;

				$sitetitle = "";

				$invoicelink = "<a href=" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . " >" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . "</a>";
				$template = $this->shortcode_variables("bookingpaidadmin");
				$details = email_template_detail("bookingpaidadmin");
				//$smsdetails = sms_template_detail("bookingpaidadmin");
				$values = array($invoiceid, $refno, $deposit, $totalamount, $custemail, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, $sitetitle, $name);
				
				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $this->adminmobile, "bookingpaidadmin");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($sendto);
				$this->email->subject('Booking Payment Notification');
				$this->email->message($message);
				$this->email->send();
		}

//send email to Supplier for booking paid
		function paid_sendEmail_supplier($details) {

			$currencycode = $details->currCode;
			$currencysign = $details->currSymbol;

				$custid = $details->bookingUser;
				$country = $details->userCountry;
				$name = $details->userFullName;
				$phone = $details->userMobile;
				$paymethod = $details->paymethod;
				$invoiceid = $details->id;
				$refno = $details->code;
				$totalamount = $details->checkoutTotal;
				$deposit = $details->checkoutAmount;
				$duedate = $details->expiry;
				$date = $details->date;
				$remaining = $details->remainingAmount;
				$custemail = $details->accountEmail;				
				$sendto = $this->supplierEmail($details->module, $details->itemid);

				$sitetitle = "";

				$invoicelink = "<a href=" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . " >" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . "</a>";
				$template = $this->shortcode_variables("bookingpaidsupplier");
				$details = email_template_detail("bookingpaidsupplier");
				//$smsdetails = sms_template_detail("bookingpaidadmin");
				$values = array($invoiceid, $refno, $deposit, $totalamount, $custemail, $custid, $country, $phone, $currencycode, $currencysign, $invoicelink, $sitetitle, $name);
				
				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $this->adminmobile, "bookingpaidadmin");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($sendto);
				$this->email->subject('Booking Payment Notification');
				$this->email->message($message);
				$this->email->send();
		}

//send email to Owner for booking paid
		function paid_sendEmail_owner($details) {
				$currencycode = $details->currCode;
				$currencysign = $details->currSymbol;

				$custid = $details->bookingUser;
				$country = $details->userCountry;
				$name = $details->userFullName;
				$phone = $details->userMobile;
				$paymethod = $details->paymethod;
				$invoiceid = $details->id;
				$refno = $details->code;
				$totalamount = $details->checkoutTotal;
				$deposit = $details->checkoutAmount;
				$duedate = $details->expiry;
				$date = $details->date;
				$remaining = $details->remainingAmount;
				$custemail = $details->accountEmail;				
			
				$sendto = $this->ownerEmail($details->module, $details->itemid);
				$sitetitle = "";
				
				$message = $this->mailHeader;
				$message .= "<h4><b>Booking Paid Successfully</b></h4>";
				$message .= "Invoice No.: " . $invoiceid . ".<br>";
				//$message .= "Payment Method: " . $paymethod . ".<br><br>";
				$message .= "Deposit Amount: " . $currencycode . " " . $currencysign . $deposit . "<br>";
				$message .= "Total Amount: " . $currencycode . " " . $currencysign . $totalamount . "<br><br>";
				$message .= "<h4><b>Customer Information</b></h4>";
				$message .= "Customer ID: " . $custid . "<br>";
				$message .= "Name : " . $name . "<br>";
				$message .= "Email : " . $custemail . "<br>";
				$message .= "Country : " . $country . "<br>";
				$message .= "Phone : " . $phone . "<br>";
				$message .= "<br> To view Invoice <a href=" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . " >" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . "</a>";
				$message .= $this->mailFooter;
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($sendto);
				$this->email->subject('Booking Payment Notification');
				$this->email->message($message);
				$this->email->send();
		}

// sending booking cancellation emails
		function booking_request_cancellation_email($useremail, $bookingid) {
//to customer
				$message = $this->mailHeader;
				$message .= "Dear Customer,<br>";
				$message .= "Your booking cancellation request for Booking ID: $bookingid has been registered, you will soon be notified about the response by email.<br>";
				$message .= "Thanks For using our service.";
				$message .= $this->mailFooter;
				
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($useremail);
				$this->email->subject('Request to cancel Booking.');
				$this->email->message($message);
				$this->email->send();
// $this->email->print_debugger();
// to admin
				$adminmessage = "Dear Admin,<br>";
				$adminmessage .= " A request has been registered to cancel Booking id: $bookingid";
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($this->adminemail);
				$this->email->subject('Request Received to cancel Booking.');
				$this->email->message($adminmessage);
				$this->email->send();
		}

// sending booking cancellation approval email
		function booking_approve_cancellation_email($useremail) {
//to customer
				$message = $this->mailHeader;
				$message .= "Dear Customer,<br>";
				$message .= "Your booking has been cancelled.<br>";
				$message .= "Thanks For using our service.";
				$message .= $this->mailFooter;

				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($useremail);
				$this->email->subject('Your Booking Cancellation has been Processed.');
				$this->email->message($message);
				$this->email->send();
		}

// sending booking cancellation rejection email
		function booking_reject_cancellation_email($useremail, $bookingid) {
//to customer
				$message = $this->mailHeader;
				$message .= "Dear Customer,<br>";
				$message .= "Your booking cancellation request for booking id: $bookingid has been rejected.<br>";
				$message .= "Thanks For using our service.";
				$message .= $this->mailFooter;

				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($useremail);
				$this->email->subject('Your Booking Cancellation Request is rejected.');
				$this->email->message($message);
				$this->email->send();
		}

// send reset password
		function reset_password($to, $newpass, $phone = '') {
				$template = $this->shortcode_variables("forgotpassword");
				$details = email_template_detail("forgotpassword");
				//$smsdetails = sms_template_detail("forgotpassword");
				$values = array($to, $newpass);
				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $phone, "forgotpassword");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($to);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
		}

//send signup email to customer
		function signupEmail($edata) {
				$phone = $edata['mobile'];
				$email = $edata['email'];
				$password = $edata['password'];
				$fullname = $edata['fullname'];
				$template = $this->shortcode_variables("customersignup");
				$details = email_template_detail("customersignup");
				//$smsdetails = sms_template_detail("customersignup");
				$values = array($fullname, $email, $password);
				
				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $phone, "customersignup");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($email);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
		}

//send newsletter
		function sendNewsletter($message, $subject, $to) {

				$msg = $this->mailHeader;
				$msg .= $message;
				$msg .= $this->mailFooter;

				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($to);
				$this->email->subject($subject);
				$this->email->message($msg);
				$this->email->send();
		}

// get admin email
		function get_admin_email() {
				$this->db->select('accounts_email');
				$this->db->where('accounts_type', 'webadmin');
				$q = $this->db->get('pt_accounts')->result();
				return $q[0]->accounts_email;
		}
// get admin email
		function get_user_email($id) {
				$this->db->select('accounts_email');
				$this->db->where('accounts_id', $id);
				$q = $this->db->get('pt_accounts')->result();
				return $q[0]->accounts_email;
		}

// get admin Mobile
		function get_admin_mobile() {
				$this->db->select('ai_mobile');
				$this->db->where('accounts_type', 'webadmin');
				$q = $this->db->get('pt_accounts')->result();
				return $q[0]->ai_mobile;
		}

// get owner email
		function ownerEmail($type, $id) {
				$email = '';
				if ($type == "hotels") {
						$this->db->select('hotel_email');
						$this->db->where('hotel_id', $id);
						$q = $this->db->get('pt_hotels')->result();
						$email = $q[0]->hotel_email;
				}
				elseif ($type == "tours") {
						$this->db->select('tour_email');
						$this->db->where('tour_id', $id);
						$q = $this->db->get('pt_tours')->result();
						$email = $q[0]->tour_email;
				}
				elseif ($type == "cars") {
						$this->db->select('car_email');
						$this->db->where('car_id', $id);
						$q = $this->db->get('pt_cars')->result();
						$email = $q[0]->car_email;
				}
				return $email;
		}
// get supplier Email
		function supplierEmail($type, $id) {
				$email = '';
				if ($type == "hotels") {
						$this->db->select('hotel_owned_by');
						$this->db->where('hotel_id', $id);
						$q = $this->db->get('pt_hotels')->result();
						$email = $this->get_user_email($q[0]->hotel_owned_by);
				}
				elseif ($type == "tours") {
						$this->db->select('tour_owned_by');
						$this->db->where('tour_id', $id);
						$q = $this->db->get('pt_tours')->result();
						$email = $this->get_user_email($q[0]->tour_owned_by);
				}
				elseif ($type == "cars") {
						$this->db->select('car_owned_by');
						$this->db->where('car_id', $id);
						$q = $this->db->get('pt_cars')->result();
						$email = $this->get_user_email($q[0]->car_owned_by);
				}
				return $email;
		}

// update mailserver settings
		function update_mailserver() {
				$defmailer = $this->input->post('defmailer');
				if ($defmailer == "php") {
						$data = array('mail_default' => $this->input->post('defmailer'), 
									 'mail_fromemail' => $this->input->post('fromemail'),
									 'mail_header' => $this->input->post('mailheader'), 
							         'mail_footer' => $this->input->post('mailfooter'));
				}
				else {
						$data = array('mail_hostname' => $this->input->post('smtphost'), 
							'mail_fromemail' => $this->input->post('fromemail'),
							'mail_username' => $this->input->post('smtpuser'), 
							'mail_password' => $this->input->post('smtppass'), 
							'mail_port' => $this->input->post('smtpport'), 
							'mail_default' => $this->input->post('defmailer'), 
							'mail_secure' => $this->input->post('smtpsecure'),
							'mail_header' => $this->input->post('mailheader'), 
							'mail_footer' => $this->input->post('mailfooter'));
				}

				$this->db->where('mail_id', '1');
				$this->db->update('pt_mailserver', $data);
		}

// resend invoice
//send email to customer
		function resend_invoice($details) {
				$name = $details[0]->ai_first_name . " " . $details[0]->ai_last_name;
				$invoiceid = $details[0]->booking_id;
				$refno = $details[0]->booking_ref_no;
				$sendto = $details[0]->accounts_email;
				$message = $this->mailHeader;
				$message .= "Dear " . $name . ",<br>";
				$message .= "You may review your invoice by visiting at: <a href=" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . " >" . base_url() . "invoice?id=" . $invoiceid . "&sessid=" . $refno . "</a>";
				$message .= $this->mailFooter;


				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($sendto);
				$this->email->subject('Booking Invoice');
				$this->email->message($message);
				$this->email->send();
		}


    //Kiwitaxi send email to customer
    function kiwitaxisend_invoice($details){
        $name = $details['first_name'] . " " . $details['last_name'];
        $invoiceid = $details['invoiceid'];
        $sendto = $details['send_email'];
        $message = $this->mailHeader;
        $message .= "Dear " . $name . ",<br>";
        $message .= "You may review your invoice by visiting at: <a href=" . base_url() . "taxi/invoice/" . $invoiceid ." >" . base_url() . "taxi/invoice/" . $invoiceid . "</a>";
        $message .= $this->mailFooter;


        $this->email->set_newline("\r\n");
        $this->email->from($this->sendfrom);
        $this->email->to($sendto);
        $this->email->subject('Booking Invoice');
        $this->email->message($message);
        $this->email->send();
    }


    //visa confirmation send email to customer
        function visasend_invoice($invoice){
        $name = $invoice[0]->first_name. " " . $invoice[0]->last_name;
        $res_code = $invoice[0]->res_code;
        $sendto = $invoice[0]->email;
        $message = $this->mailHeader;
        $message .= "Dear " . $name . ",<br>";
        $message .= "View your invoice: <a href=" . base_url() . "visa/invoice/" . $res_code ." >" . base_url() . "visa/invoice/" . $res_code . "</a>";
        $message .= $this->mailFooter;


        $this->email->set_newline("\r\n");
        $this->email->from($this->sendfrom);
        $this->email->to($sendto);
        $this->email->subject('Booking Invoice');
        $this->email->message($message);
        $this->email->send();
    }


		function get_siteTitleUrl() {
				$appsettings = $this->Settings_model->get_settings_data();
				$resultArray = array("title" => $appsettings[0]->site_title,"url" => $appsettings[0]->site_url);
				return $resultArray;
		}

	

// get mailserver settings
		function get_mailserver() {
				$this->db->where('mail_id', '1');
				return $this->db->get('pt_mailserver')->result();
		}
// send Verification Email

		public function email_verified($to, $pass, $name, $phone, $accType = null) {
			if($accType == "customers"){
				$loginurl = "<a href=" . base_url() . "login >" . base_url() . "login </a>";
				$pass = "";
			}else{

				$loginurl = "<a href=" . base_url() . "supplier >" . base_url() . "supplier </a>";
			}
				
			if($accType == "customers"){
				$template = $this->shortcode_variables("verifycustomeraccount");
				$details = email_template_detail("verifycustomeraccount");

				//$smsdetails = sms_template_detail("verifyaccount");
				$values = array($name, $to, $loginurl);
			}else{
				$template = $this->shortcode_variables("verifyaccount");
				$details = email_template_detail("verifyaccount");

				//$smsdetails = sms_template_detail("verifyaccount");
				$values = array($name, $to, $pass, $loginurl);
			}


				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $phone, "verifyaccount");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($to);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
		}
// send New supplier email to supplier

		public function supplier_signup($edata) {
				$details = email_template_detail("supplierregister");
				//$smsdetails = sms_template_detail("supplierregister");

				$message = $this->mailHeader;
				$message .= $details[0]->temp_body;
				$message .= $this->mailFooter;

				//sendsms($smsdetails[0]->temp_body, $edata['phone'], "supplierregister");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($edata['email']);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
		}

// send New customer email to supplier

		public function customer_signup($edata) {
				$details = email_template_detail("customerregister");
				//$smsdetails = sms_template_detail("supplierregister");

				$message = $this->mailHeader;
				$message .= $details[0]->temp_body;
				$message .= $this->mailFooter;

				//sendsms($smsdetails[0]->temp_body, $edata['phone'], "supplierregister");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($edata['email']);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
		}

// send New supplier signup email to Admin

		public function new_supplier_email($edata) {
				$template = $this->shortcode_variables("supplierregisteradmin");
				$details = email_template_detail("supplierregisteradmin");
				//$smsdetails = sms_template_detail("supplierregisteradmin");
				$values = array($edata['name'], $edata['email'], $edata['address'], $edata['phone']);

				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $this->adminmobile, "supplierregisteradmin");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($this->adminemail);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
		}

// send New customer signup email to Admin

		public function new_customer_email($edata) {
				$template = $this->shortcode_variables("customerregisteradmin");
				$details = email_template_detail("customerregisteradmin");
				//$smsdetails = sms_template_detail("supplierregisteradmin");
				$values = array($edata['name'], $edata['email'], $edata['address'], $edata['phone']);

				$message = $this->mailHeader;
				$message .= str_replace($template, $values, $details[0]->temp_body);
				$message .= $this->mailFooter;

				//$smsmessage = str_replace($template, $values, $smsdetails[0]->temp_body);
				//sendsms($smsmessage, $this->adminmobile, "supplierregisteradmin");
				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($this->adminemail);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
		}

		public function sendtotest($template) {
				$details = email_template_detail($template);

				$message = $this->mailHeader;
				$message .= $details[0]->temp_body;
				$message .= $this->mailFooter;

				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($this->adminemail);
				$this->email->subject($details[0]->temp_subject);
				$this->email->message($message);
				$this->email->send();
				return '1';
		}

		public function quickemail($from, $body, $to, $subject) {
				$message = $this->mailHeader;
				$message .= $body;
				$message .= $this->mailFooter;

				$this->email->set_newline("\r\n");
				$this->email->from($from);
				$this->email->to($to);
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();
		}

		public function shortcode_variables($template) {
				if ($template == "bookingorderadmin") {
						$result = array("{invoice_id}", "{invoice_code}", "{deposit_amount}", "{total_amount}", "{customer_email}", "{customer_id}", "{country}", "{phone}", "{currency_code}", "{currency_sign}", "{invoice_link}", "{site_title}", "{fullname}");
				}elseif ($template == "bookingordersupplier") {
						$result = array("{invoice_id}", "{invoice_code}", "{deposit_amount}", "{total_amount}", "{customer_email}", "{customer_id}", "{country}", "{phone}", "{currency_code}", "{currency_sign}", "{invoice_link}", "{site_title}", "{fullname}");
				}
				elseif ($template == "bookingpaidadmin") {
						$result = array("{invoice_id}", "{invoice_code}", "{deposit_amount}", "{total_amount}", "{customer_email}", "{customer_id}", "{country}", "{phone}", "{currency_code}", "{currency_sign}", "{invoice_link}", "{site_title}", "{fullname}");
				}
				elseif ($template == "bookingpaidsupplier") {
						$result = array("{invoice_id}", "{invoice_code}", "{deposit_amount}", "{total_amount}", "{customer_email}", "{customer_id}", "{country}", "{phone}", "{currency_code}", "{currency_sign}", "{invoice_link}", "{site_title}", "{fullname}");
				}
				elseif ($template == "supplierregister") {
						$result = array("{fullname}");
				}
				elseif ($template == "forgotpassword") {
						$result = array("{username}", "{password}");
				}
				elseif ($template == "bookingordercustomer") {
						$result = array("{invoice_id}", "{invoice_code}", "{deposit_amount}", "{total_amount}", "{customer_email}", "{customer_id}", "{country}", "{phone}", "{currency_code}", "{currency_sign}", "{invoice_link}", "{site_title}", "{due_date}", "{fullname}");
				}
				elseif ($template == "bookingpaidcustomer") {
						$result = array("{invoice_id}", "{invoice_code}", "{deposit_amount}", "{total_amount}", "{customer_email}", "{customer_id}", "{country}", "{phone}", "{currency_code}", "{currency_sign}", "{invoice_link}", "{site_title}", "{remaining_amount}", "{fullname}");
				}
				elseif ($template == "verifyaccount") {
						$result = array("{fullname}", "{email}", "{password}", "{loginurl}");
				}elseif ($template == "verifycustomeraccount") {
						$result = array("{fullname}", "{email}", "{password}", "{loginurl}");
				}
				elseif ($template == "supplierregisteradmin") {
						$result = array("{fullname}", "{email}", "{address}", "{phone}");
				}elseif ($template == "customerregisteradmin") {
						$result = array("{fullname}", "{email}", "{address}", "{phone}");
				}
				elseif ($template == "customersignup") {
						$result = array("{fullname}", "{email}", "{password}");
				}
				return $result;
		}

		function send_contact_email($from, $data) {

				$subject = "Contact From Website: ".$data['contact_name'] . " - ";
				$subject .= $data['contact_subject'];

				$msg = $this->mailHeader;
				$msg .= $data['contact_message'];
				$msg .= $this->mailFooter;

				$this->email->set_newline("\r\n");
				$this->email->from($from);
				$this->email->to($data['contact_email']);
				$this->email->cc($this->adminemail);
				$this->email->subject($subject);
				$this->email->message($msg);
				return $this->email->send();
		}
// special offers contact email
		function offerContactEmail() {
			$toemail = $this->input->post('toemail');
			$msg = $this->input->post('message');
			$phone = $this->input->post('phone');
			$name = $this->input->post('name');

			$message = $this->mailHeader;
			$message .= "Name: ".$name."<br>";
			$message .= "Phone: ".$phone."<br>";
			$message .= "Message: ".$msg."<br>";
			$message .= $this->mailFooter;

				$this->email->set_newline("\r\n");
				$this->email->from($this->sendfrom);
				$this->email->to($toemail);
				$this->email->subject('Special Offer Contact Email');
				$this->email->message($message);
				if (!$this->email->send()) {
						//echo $this->email->print_debugger();
				}
				else {
						//echo 'Email sent';
				}
		}

}