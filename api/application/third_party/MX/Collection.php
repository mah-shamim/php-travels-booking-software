<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Collection
{
    public $items = array();

	/**
     * Module constructor
     * 
     * @return void
     */
    public function __construct()
    {
        // TODO...
    }
    
    /**
     * Bind service to the magic box
     * 
     * @return object
     */
    public function bind($key, $val)
    {
        $this->items[$key] = $val;
    }

    /**
     * Pass servic key to return the service object form the magic box.
     * 
     * @return object
     */
    public function service($key)
    {
        return $this->items[$key];
    }
}