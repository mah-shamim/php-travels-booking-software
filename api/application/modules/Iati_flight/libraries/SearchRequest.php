<?php


class SearchRequest extends BaseRequest
{
	
	public static $METHOD = "POST";
	public static $SERVICE_URL_PATH = "flightSearch";
	
	protected $fromAirport;  //String
	protected $allinFromCity;  //boolean
	protected $toAirport; //String
	protected $allinToCity; //boolean
	
	protected $fromDate;  //Date
	protected $returnDate; //Date
	
	protected $adult; //int	
	protected $child; //int
	protected $infant; //int
	protected $senior; //int
	protected $student; //int
	protected $young; //int
	protected $military; //int
	protected $disable; //int
	
	protected $cip; //boolean
	protected $currency; //String
	
	protected $usePersonFares; //boolean
	
	protected $filterProviders; //String[]
	protected $classType; //String
 	
}
