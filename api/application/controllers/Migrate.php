<?php

class Migrate extends MX_Controller
{

 public function __construct()
    {
        parent::__construct();


    }

        public function index()
        {
                $this->load->library('migration');
            print_r('debug','Found migrations: '.print_r($this->migration->find_migrations(),true));
                if ($this->migration->current() === FALSE)
                {
                        show_error($this->migration->error_string());
                }

                else {
                exit ("success");
                }
        }

}