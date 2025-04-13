<?php

class Passenger
{
	public $name; //String
	public $surname; //String
	public $birthdate; //Date || Format: YYYY-MM-DD
	public $gender; //enum String | ADULT, CHILD, INFANT, SENIOR, YOUNG, STUDENT, DISABLED, MILITARY, TEACHER
	public $type; //enum String | MALE, FEMALE
	
	public $identityNo; //String || will only be used if Identity type is TC_NO
	public $passport; //Passport Object || will only be used if Identity type is PASSPORT
	public $foid; //Foid Object || will only be used if Identity type is FOID
	
	public $mobilePhoneNumber; //String
	public $eticket; //String
}	