<?php


class PriceRequest extends BaseRequest
{
	public static $METHOD = "POST";
	public static $SERVICE_URL_PATH = "priceDetail";
	
	protected $searchId;  //String
	protected $currency;  //String
	protected $fareRefereces; //FlightFareReference Object Array
	protected $passengers; //FlightPassenger Object Array
	protected $cip; //Boolean
	
}