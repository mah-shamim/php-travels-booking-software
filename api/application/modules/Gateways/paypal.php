<?php

function paypal_config() {

	$configarray = array( "FriendlyName" => array( "Type" => "System", "Value" => "PayPal" ), "UsageNotes" => array( "Type" => "System", "Value" => "You must enable IPN inside your PayPal account and set the URL to " . base_url() ), "email" => array( "FriendlyName" => "PayPal Email", "Type" => "text", "Size" => "40","Description" => "You must enable IPN inside your PayPal account and set the Return URL to  ".base_url()."invoice/notifyUrl/paypal" ), "sandbox" => array( "FriendlyName" => "Sandbox", "Type" => "yesno", "Description" => "Tick to enable test mode" ));
	return $configarray;
}


function paypal_link($params) {
	$invoiceid = $params['invoiceid'];
	$paypalemail = $params['email'];

	$code = "<table><tr>";
	$isMobile = isMobileDevice();
	$target = "";
	if($isMobile){
	$target = "target = '_blank'";
	}

if($params['sandbox']){
	$code .= "<td><form action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\" " . $target . " >";
}else{
	$code .= "<td><form action=\"https://www.paypal.com/cgi-bin/webscr\"  method=\"post\" " . $target . " >";

	}

	$code .="<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
			  <input type=\"hidden\" name=\"business\" value=\"" . $paypalemail . "\">";

	
		

	$code .= "<input type=\"hidden\" name=\"charset\" value=\"" . $params['charset'] . "\">
		<input type=\"hidden\" name=\"amount\" value=\"" . $params['amount'] . "\"> 
		
<input type=\"hidden\" name=\"currency_code\" value=\"" . $params['currency'] . "\">
<input type=\"hidden\" name=\"custom\" value=\"" . $params['invoiceid'] . "\">
<input type=\"hidden\" name=\"item_name\" value=\"" . $params['description'] . "\">
<input type=\"hidden\" name=\"return\" value=\"" .base_url(). "invoice?&id=".$params['invoiceid']."&sessid=".$params['invoiceref']."\">
<input type=\"hidden\" name=\"cancel_return\" value=\"" .base_url(). "invoice?&id=".$params['invoiceid']."&sessid=".$params['invoiceref']."\">
<input type=\"hidden\" name=\"notify_url\" value=\"" . base_url(). "invoice/notifyUrl/paypal\">
<input type=\"hidden\" name=\"rm\" value=\"2\">
<input type=\"image\" class=\"paybtn\" src=\"https://www.paypal.com/en_US/i/btn/x-click-but03.gif\" border=\"0\" name=\"submit\" alt=\"Make a one time payment with PayPal\">
</form></td>";


	$code .= "</tr></table>";
	return $code;
}

//function for verification of payment. It will be used in notify url
function paypal_verifypayment($params){

//funciton should return an array of result with status = success/fail, invoiceid, amount paid, transaction id if any 
$result = array("status" => "fail","invoiceid" => "","paid" => 0,"transactionid" => "");

$postipn = "cmd=_notify-validate";
$orgipn = "";

foreach ($_POST as $key => $value) {
	$orgipn .= ("" . $key . " => " . $value . "\r\n");
	$postipn .= "&" . $key . "=" . urlencode(html_entity_decode($value, ENT_QUOTES));
}

if($params['sandbox']){
	$reply = curlCall("https://www.sandbox.paypal.com/cgi-bin/webscr", $postipn);
}else{
	$reply = curlCall("https://www.paypal.com/cgi-bin/webscr", $postipn);

	}



if (!strcmp($reply, "VERIFIED")) {
	$paypalemail = $_POST['receiver_email'];
$payment_status = $_POST['payment_status'];
$txn_type = $_POST['txn_type'];
$txn_id = $_POST['txn_id'];
$mc_gross = $_POST['mc_gross'];
$mc_fee = $_POST['mc_fee'];
$invoiceid = $_POST['custom'];


if ($txn_type == "web_accept" && $payment_status == "Completed") {
	
	$result = array("status" => "success","invoiceid" => $invoiceid,"paid" => $mc_gross,"transactionid" => $txn_id);
	return $result;

}

} else {
	if (!strcmp($reply, "INVALID")) {
		return $result;
		exit();
	} else {
		return $result;
		
	}
}



}

function isMobileDevice(){
	$useragent = $_SERVER['HTTP_USER_AGENT'];

if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
	return TRUE;
}else{
	return FALSE;
}

}