<?php
class Juniper_lib {

    public function __construct()
    {
    }

    public function callApi($code,$data,$search)
    {

        try {
            $client = new \SoapClient("http://xml.gte.travel/webservice/JP/WebServiceJP.asmx?WSDL", array(
                'soap_version' => 'SOAP_1_2',
                'encoding' => 'UTF-8',
                'exceptions' => true,
                'stream_context' => stream_context_create(array(
                    'http' => array(
                        'header' => array(
                            'Content-Type: text/xml; charset=UTF-8',
                            'Accept-Encoding: gzip, deflate'
                        )),
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    )
                )),
                'trace' => true,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
            ));

            $client->__setLocation("http://xml.gte.travel/WebService/jp/operations/availtransactions.asmx");

            $response = $client->HotelAvail([
                "HotelAvailRQ" =>[
                    "Version" => "1.1",
                    "Language" => "en",
                    "Login" => [
                        "Email" => $data->user,
                        "Password" => $data->jpassword
                    ],
                    "Paxes" =>[
                        "Pax"=> [
                            [
                            "IdPax"=>"1",
                            "Age"=>30
                        ],
                        [
                            "IdPax"=>"2",
                            "Age"=>30
                        ],
                            ],

                    ],
                    "HotelRequest" => [
                        "SearchSegmentsHotels" => [
                        "SearchSegmentHotels" => [
                            "Start"=> date("Y-m-d", strtotime($search->hotelcheckin)),
                            "End"=> date("Y-m-d", strtotime($search->hotelcheckout)),
                        ],
                        "CountryOfResidence"=>"ES",
                            "HotelCodes"=>[
                                "HotelCode" => $code,

                            ],

                    ],
                    "RelPaxesDist"=>[
                        "RelPaxDist"=>[
                            "RelPaxes"=>[
                                "RelPax"=>[
                                    [
                                    "IdPax"=>"1",
                                ],
                              [
                                    "IdPax"=>"2",
                                ],
                                    ],

                            ],
                        ],
                    ],
                    ],
                    "AdvancedOptions"=>[
                        "ShowHotelInfo"=>true,
                        "ShowOnlyBestPriceCombination"=>true,
                        "TimeOut"=>8000,
                    ],
                ],
            ]);

            //header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }



    public function getimage($code,$data)
    {
        try {
            $client = new \SoapClient("http://xml.gte.travel/webservice/JP/WebServiceJP.asmx?WSDL", array(
                'soap_version' => 'SOAP_1_2',
                'encoding' => 'UTF-8',
                'exceptions' => true,
                'stream_context' => stream_context_create(array(
                    'http' => array(
                        'header' => array(
                            'Content-Type: text/xml; charset=UTF-8',
                            'Accept-Encoding: gzip, deflate'
                        )),
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    )
                )),
                'trace' => true,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
            ));

            $client->__setLocation("http://xml.gte.travel/WebService/jp/operations/staticdatatransactions.asmx");

            $response = $client->HotelContent([
                "HotelContentRQ" =>[
                    "Version" => "1.1",
                    "Language" => "en",
                    "Login" => [
                        "Email" => $data->user,
                        "Password" => $data->jpassword
                    ],
                    "HotelContentList" => [
                        "Hotel" => [
                            "Code" => $code,
                        ]
                    ],
                ],
            ]);

            //header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getdetail($code,$RatePlanCode,$data,$search)
    {

        try {
            $client = new \SoapClient("http://xml.gte.travel/webservice/JP/WebServiceJP.asmx?WSDL", array(
                'soap_version' => 'SOAP_1_2',
                'encoding' => 'UTF-8',
                'exceptions' => true,
                'stream_context' => stream_context_create(array(
                    'http' => array(
                        'header' => array(
                            'Content-Type: text/xml; charset=UTF-8',
                            'Accept-Encoding: gzip, deflate'
                        )),
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    )
                )),
                'trace' => true,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
            ));

            $client->__setLocation("http://xml.gte.travel/WebService/jp/operations/checktransactions.asmx");

            $response = $client->HotelBookingRules([
                "HotelBookingRulesRQ" =>[
                    "Version" => "1.1",
                    "Language" => "en",
                    "Login" => [
                        "Email" => $data->user,
                        "Password" => $data->jpassword
                    ],
                    "HotelBookingRulesRequest"=>[
                    "HotelOption" => [
                        "RatePlanCode" => $RatePlanCode,
                    ],
                    "SearchSegmentsHotels" =>[
                        "SearchSegmentHotels"=>[
                            "Start"=> date("Y-m-d", strtotime($search->hotelcheckin)),
                            "End"=> date("Y-m-d", strtotime($search->hotelcheckout)),
                        ],
                        "HotelCodes"=>[
                            "HotelCode"=>$code,
                        ]
                    ],
                    ],
                    "AdvancedOptions"=>[
                        "ShowBreakdownPrice"=>true,
                    ],
                ],

            ]);

            //header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }



    public function booking($payload,$data)
    {
        $payload['data'] = json_decode($payload['booking_response']);
        $book_id = $payload["hotel_id"];
        $Currency = $payload["set_currencies"];
        $Maximum = $payload["actu_price"];
        $Minimum = $payload["Minimum"];
        $book_code = $payload["booking_code"];

        try {
            $client = new \SoapClient("http://xml.gte.travel/webservice/JP/WebServiceJP.asmx?WSDL", array(
                'soap_version' => 'SOAP_1_2',
                'encoding' => 'UTF-8',
                'exceptions' => true,
                'stream_context' => stream_context_create(array(
                    'http' => array(
                        'header' => array(
                            'Content-Type: text/xml; charset=UTF-8',
                            'Accept-Encoding: gzip, deflate'
                        )),
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    )
                )),
                'trace' => true,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE
            ));

            $client->__setLocation("http://xml.gte.travel/webservice/jp/operations/booktransactions.asmx");

            $response = $client->HotelBooking([
                "HotelBookingRQ" =>[
                    "Version" => "1.1",
                    "Language" => "en",
                    "Login" => [
                        "Email" => "TestXMLEmtlak",
                        "Password" => "qbz67KCvCG!",
                    ],
                    "Paxes" =>[
                        "Pax"=>
                        [
                            [
                            "IdPax"=>"1",
                            "Name"=>"Holder Name A",
                            "Surname"=>"Holder Surname A",
                             "Age"=>30,
                            "Nationality"=>"ES",
                        ],
                       [
                            "IdPax"=>"2",
                            "Name"=>"Second Passenger Name",
                            "Surname"=>"Second Passenger Surname",
                            "Age"=>30,
                        ],
                            ],
                    ],
                    "Holder"=>[
                        "RelPax"=>[
                                "IdPax"=>"1",
                        ],
                    ],
                    "ExternalBookingReference"=>$payload["agentReferenceNumber"],
                    "Comments"=>[
                        "Comment"=>"Booking comment",
                    ],
                    "Elements"=>[
                        "HotelElement"=>[
                            "BookingCode"=>$book_code,
                            "RelPaxesDist"=>[
                                "RelPaxDist"=>[
                                    "RelPaxes"=>[
                                        "RelPax"=>[
                                            [
                                                "IdPax"=>"1",
                                            ],
                                            [
                                                "IdPax"=>"2",
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            "Comments"=>[
                                "Comment"=>"Booking line comment",
                            ],
                            "HotelBookingInfo" => [
                                        "Start"=> date("Y-m-d", strtotime($payload["checkIn"])),
                                        "End"=> date("Y-m-d", strtotime($payload["checkOut"])),
                                    "Price"=>[
                                        "PriceRange" => [
                                            "Minimum"=>$Minimum,
                                            "Maximum"=> $Maximum,
                                            "Currency"=>$Currency,
                                            ],
                                    ],
                                "HotelCode"=>$book_id,
                            ],
                        ],
                    ],
                    "AdvancedOptions"=>[
                        "ShowBreakdownPrice"=>true,
                    ],
                ],
            ]);

            //header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


}