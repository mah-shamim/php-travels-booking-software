<?php

class Sms_notification {

    public  $endpoint;
    private $api_username;
    private $api_password;
    private $sender;
    public  $recepient;
    public  $message;

    public function __construct()
    {
        $nixmo              = sms_api_loader('sms_api');
        $this->endpoint     = $nixmo->api_endpoint;
        $this->api_username = $nixmo->api_username;
        $this->api_password = $nixmo->api_password;
        $this->sender       = 0220;
    }

    public function send()
    {
        $response = $this->curlCall();

        return $response;
    }

    private function curlCall()
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->endpoint,
            CURLOPT_USERAGENT => 'SMS Notification',
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
            CURLOPT_POSTFIELDS => urldecode(http_build_query(array(
                'api_key'   => $this->api_username,
                'api_secret' => $this->api_password,
                'from'      => $this->sender,
                'to'        => $this->recepient,
                'text'      => $this->message,
            )))
        ));
        // Send the request & save response to $resp
        $response = new StdClass();
        $result = curl_exec($curl);
        if(empty($result)) {
            $response->status  = 'fail';
            $response->message = 'Unable to send message';
        } elseif(array_key_exists('error-text', ((array) json_decode($result)->messages[0]))){
            $response->status  = 'fail';
            $message = (array) json_decode($result)->messages[0];
            $response->message = $message['error-text'];
        } else {
            $response->status = 'success';
            $response->message  = 'Message sent successfully';
        }
        // Close request to clear up some resources
        curl_close($curl);

        return $response;
    }
}