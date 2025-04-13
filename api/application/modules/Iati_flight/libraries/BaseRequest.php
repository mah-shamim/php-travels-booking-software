<?php

abstract class BaseRequest
{
	
	private function encodeJson(){
		return json_encode(get_object_vars($this),JSON_PRETTY_PRINT);
	}
	
	public function createRequest(){
		return preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', $this->encodeJson()); //remove null values
	}
   	
	public function __set($key, $value)
    {
        $property = "$key";
        if (!property_exists($this, $property)) throw new Exception("Property($key) not found");
    	
        $this->{$property} = $value;
    }

    public function __get($key)
    {
        $property = "$key";
        if (!property_exists($this, $property)) throw new Exception("Property($key) not found");

        return $this->{$property};
    }
	
}