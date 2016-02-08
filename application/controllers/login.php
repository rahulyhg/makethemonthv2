<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

 function __construct(){
    parent::__construct();
    $this->load->helper('url');
 }

 function index(){
    $session_data = $this->session->userdata('logged_in');
    if($session_data){        
        redirect($session_data['account_type'], 'refresh');
    }
    else{
        $this->load->helper(array('form'));
        $this->load->view('login_view');
    }
   
 }
 function logout(){
    $this->session->unset_userdata('logged_in');
    redirect('login', 'refresh');
 }

}
?>