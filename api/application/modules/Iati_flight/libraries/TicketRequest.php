<?php

class TicketRequest extends BaseRequest
{
	public static $METHOD = "POST";
	public static $SERVICE_URL_PATH = "makeTicket";
	
	protected $priceDetailId; //String
	protected $contactInfo; //ContactInfo Object
	protected $cip; //boolean
	protected $corporatePin; //String
	protected $passengers; //Passenger Object Array
	protected $notes; //String
	
	protected $test; //boolean
	
	protected $agencyExtra; //double
	
}