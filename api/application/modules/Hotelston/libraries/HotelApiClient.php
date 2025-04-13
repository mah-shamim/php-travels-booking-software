<?php
class HotelApiClient 
{
    public $client;

    public function __construct()
    {
    }

    public function callApi($hotel_id,$data)
    {
        try {
            $client = new \SoapClient($data->staticDataService, array(
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
                'trace' => true
            ));

            $client->__setLocation($data->staticDataService_end);

            $response = $client->getHotelDetails([
                "loginDetails" => [
                    "email" => $data->email,
                    "password" => $data->password
                ],
                "hotelId" => $hotel_id
            ]);

            //header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getroom($hotel_id,$data,$searchForm)
    {


        if($searchForm->hotelchildren == 0){
            $checkchlid = [
                "adults" => $searchForm->hoteladult,
                "children" => $searchForm->hotelchildren,
                "seqNo" => 0,

            ];
        }else{
            $checkchlid = [
                "adults" => $searchForm->hoteladult,
                "children" => $searchForm->hotelchildren,
                "seqNo" => 0,
                "childAge" => 8,

            ];
        }

        try {
            $client = new \SoapClient("https://dev.hotelston.com/ws/HotelServiceV2?wsdl", array(
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
                'trace' => true
            ));

            $client->__setLocation("http://dev.hotelston.com/ws/HotelServiceV2/HotelServiceHttpSoap11Endpoint/");


            $response = $client->searchHotels([
                "loginDetails" => [
                    "email" => $data->email,
                    "password" => $data->password
                ],
                "criteria" => [
                    "checkIn" => date("Y-m-d", strtotime($searchForm->hotelcheckin)),
                    "checkOut" => date("Y-m-d", strtotime($searchForm->hotelcheckout)),
                    "clientNationality" => "LT",
                    "hotelSelector" =>[
                        "hotelIds"=>[
                            "hotelId" => [$hotel_id]
                        ]
                    ],
                    "room" =>$checkchlid,
                ]

            ]);
            // header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }



    public function callApibooking($payload,$data)
    {
        $payload['data'] = json_decode($payload['booking_response']);
        try {
            $client = new \SoapClient("https://dev.hotelston.com/ws/HotelServiceV2?wsdl", array(
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
                'trace' => true
            ));

            $client->__setLocation("http://dev.hotelston.com/ws/HotelServiceV2/HotelServiceHttpSoap11Endpoint/");

            $response = $client->bookHotel([
                "loginDetails" => [
                    "email" => $data->email,
                    "password" => $data->password
                ],
                "currency" =>$payload["set_currencies"],
                "hotelId" =>$payload["hotel_id"],
                "checkIn" => date("Y-m-d", strtotime($payload["checkIn"])),
                "checkOut" =>date("Y-m-d", strtotime($payload["checkOut"])),
                "agentReferenceNumber" =>$payload["agentReferenceNumber"],
                "clientNationality" =>"LT",
                "contactPerson" => [
                    "title" => $payload['data']->title,
                    "firstname" => $payload['data']->first_name,
                    "lastname" => $payload['data']->last_name,
                    "email" => $data->book_email,
                    "phone" => $payload['data']->number,
                ],
                "room" => [
                    "seqNo" => 0,
                    "roomId" => $payload['room_id'],
                    "roomTypeId" => $payload['roomTypeId'],
                    "boardTypeId" => $payload['boardTypeId'],
                    "price" => $payload['price'],
                    "adult" => [
                        "title" =>$payload['data']->title0,
                        "firstname" => $payload['data']->first_name0,
                        "lastname" => $payload['data']->last_name0,
                    ],
                    "adult" => [
                        "title" =>$payload['data']->title1,
                        "firstname" => $payload['data']->first_name1,
                        "lastname" => $payload['data']->last_name1,
                    ],
                    "child" => [
                        "firstname" =>$payload['data']->first_name_children,
                        "lastname" =>$payload['data']->last_name_children,
                        "age" =>8,
                    ]
                ],

            ]);

             header("Content-Type: application/json");
            return $response;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}