<?php

class MY_Email extends CI_Email {

    protected $CI;

    public $admin_email;
    public $admin_mobile;
    Public $site_title;
    public $site_url;
    public $template_vars;
    public $template_values;
    public $mail_header;
    public $mail_footer;
    public $mail_secure;

    public $protocol;
    public $smtp_host;
    public $smtp_port;
    public $smtp_user;
    public $smtp_pass;
    public $mailtype  = 'html';
    public $charset   = 'iso-8859-1';
    public $mail_fromemail;


    public function __construct()
    {
        $this->CI =& get_instance();

        $this->load_admin_account_data();
        $this->load_app_settings();
        $this->load_mailserver_settings();

        $this->site_url        = $this->add_http($this->site_url);
        $this->template_vars   = array("{siteTitle}", "{siteUrl}");
        $this->template_values = array($this->site_title, $this->site_url);

        $this->mail_header = str_replace($this->template_vars, $this->template_values, $this->mail_header);
        $this->mail_footer = str_replace($this->template_vars, $this->template_values, $this->mail_footer);
        
        if ($this->protocol == "smtp") 
        {    
            if($this->mail_secure != "no")
            {
                $this->smtp_host = $this->mail_secure . "://" . $this->smtp_host;
            }   
        }

        $this->configuration = array(
            'protocol'  => $this->protocol, 
            'smtp_host' => $this->smtp_host, 
            'smtp_port' => $this->smtp_port, 
            'smtp_user' => $this->smtp_user, 
            'smtp_pass' => $this->smtp_pass, 
            'mailtype'  => $this->mailtype, 
            'charset'   => $this->charset, 
            'wordwrap'  => TRUE,
            'smtp_auth' => TRUE,
            'newline'   => "\r\n",
        );
        
        parent::__construct($this->configuration);
    }

    private function add_http($url) 
    {
        if ( ! preg_match("~^(?:f|ht)tps?://~i", $url) ) 
        {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https://' : 'http://';
            $url  = $http . $url;
        }

        return $url;
	}

    private function load_admin_account_data() 
    {
        $this->CI->db->select('accounts_email, ai_mobile');
        $this->CI->db->where('accounts_type', 'webadmin');
        $dataAdapter = $this->CI->db->get('pt_accounts');
        $dataset = $dataAdapter->row();
        
        $this->admin_email = $dataset->accounts_email;
        $this->admin_mobile = $dataset->accounts_email;
    }

    private function load_app_settings() 
    {
        $dataAdapter = $this->CI->db->get('pt_app_settings');
		$dataset = $dataAdapter->row();

        $this->site_title = $dataset->site_title;
        $this->site_url = $dataset->site_url;
    }

    private function load_mailserver_settings() 
    {
        $this->CI->db->where('mail_id', 1);
        $dataAdapter = $this->CI->db->get('pt_mailserver');
        $dataset = $dataAdapter->row();
        
        $this->mail_header = $dataset->mail_header;
        $this->mail_footer = $dataset->mail_footer;
        $this->mail_secure = $dataset->mail_secure;
        
        $this->mail_fromemail = $dataset->mail_fromemail;
        $this->protocol = $dataset->mail_default;
        $this->smtp_host = $dataset->mail_hostname;
        $this->smtp_port = $dataset->mail_port;
        $this->smtp_user = $dataset->mail_username;
        $this->smtp_pass = $dataset->mail_password;
    }

}