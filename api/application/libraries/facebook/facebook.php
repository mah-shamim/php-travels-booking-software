<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( session_status() == PHP_SESSION_NONE ) {
  session_start();
}

// Autoload the required files
require_once( APPPATH . 'libraries/facebook/sdk/autoload.php' );

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;


class facebook {
  var $ci;
  var $helper;
  var $session;
  var $permissions;

  public function __construct() {
    $this->ci =& get_instance();
    $settings = $this->ci->db->get('pt_fb_settings')->result();
    $this->permissions = array(
  'email'
);

    // Initialize the SDK
    FacebookSession::setDefaultApplication( $settings[0]->app_id, $settings[0]->app_secret );
    $redirecturl = base_url().'account';
    // Create the login helper and replace REDIRECT_URI with your URL
    // Use the same domain you set for the apps 'App Domains'
    // e.g. $helper = new FacebookRedirectLoginHelper( 'http://mydomain.com/redirect' );
    $this->helper = new FacebookRedirectLoginHelper($redirecturl);

    if ( $this->ci->session->userdata('fb_token') ) {
      $this->session = new FacebookSession( $this->ci->session->userdata('fb_token') );

      // Validate the access_token to make sure it's still valid
      try {
        if ( ! $this->session->validate() ) {
          $this->session = null;
        }
      } catch ( Exception $e ) {
        // Catch any exceptions
        $this->session = null;
      }
    } else {
      // No session exists
      try {
        $this->session = $this->helper->getSessionFromRedirect();
      } catch( FacebookRequestException $ex ) {
        // When Facebook returns an error
      } catch( Exception $ex ) {
        // When validation fails or other local issues
      }
    }

    if ( $this->session ) {
      $this->ci->session->set_userdata( 'fb_token', $this->session->getToken() );

      $this->session = new FacebookSession( $this->session->getToken() );
    }
  }

  /**
   * Returns the login URL.
   */
  public function login_url() {
    return $this->helper->getLoginUrl( $this->permissions );
  }

  /**
   * Returns the current user's info as an array.
   */
  public function get_user() {
    if ( $this->session ) {
      /**
       * Retrieve Users Profile Information
       */
      // Graph API to request user data
      $request = ( new FacebookRequest( $this->session, 'GET', '/me' ) )->execute();

      // Get response as an array
      $user = $request->getGraphObject()->asArray();

      return $user;
    }
    return false;
  }

  public function logoutfb(){
     $this->ci->session->set_userdata('fb_token','');
  }

}