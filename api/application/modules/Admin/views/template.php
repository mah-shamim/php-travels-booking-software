<?php
if (! isset($show_sidebar)){
    $this->load->view('includes/header');
}

$this->load->view($main_content);

$this->load->view('includes/footer');