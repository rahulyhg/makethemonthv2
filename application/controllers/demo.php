<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Demo extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('city');
        $this->load->model('scenario');
        $this->load->model('question');
        $this->load->model('grocery');
        $this->load->model('rent');
        $this->load->model('f_emails');
        $session_data = $this->session->userdata('logged_in');
        if($session_data){
            if($session_data['account_type']=='admin' || $session_data['account_type']=='superadmin'){

            }else{
                redirect('/', 'refresh');
            }
        }
        else{
            redirect('/', 'refresh');
        }
    }

    function _remap($method, $params = array()){
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            redirect('');
        }
    }

    function index(){
        redirect('/');
    }
    function city($city){
        $data['lang'] = $this->session->userdata('local_language');
        if(isset($data['lang']) && $data['lang'] == 'french'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['template'] = "city-template";
        $data['city_info'] = $this->city->load_city($city);
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function not_found(){
        $data['template'] = "not-found";
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function scenarios($city){
        $data['template'] ='ajax/load-scenario';
        $data['scenarios'] = $this->scenario->get_all_by_city($city);
        $data['footer_url'] = $this->city->load_city($city);
        $data['has_sidebar'] = false;
        $data['lng'] = 'english';
        $this->lang->load($data['lng'], $data['lng']);
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function scenario($city,$scenario_id){
        $data['template'] ='ajax/load-single-scenario';
        $data['scenario'] = $this->scenario->get_single($scenario_id);
        $data['city'] = $this->city->load_city($city);
        $data['has_sidebar'] = 'has-menu';
        $data['lng'] = 'english';
        $this->lang->load($data['lng'], $data['lng']);
        $data['load_menu'] = true;
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function rent($scenario_id){
        $data['template'] ='ajax/rent-scene';
        $data['rent'] = $this->scenario->load_rent($scenario_id);
        $data['has_sidebar'] = 'has-menu';
        $data['lng'] = 'english';
        $this->lang->load($data['lng'], $data['lng']);
        $data['body_class'] = "dark-class";
        $data['load_menu'] = true;
        $this->load->view('frontend/template', $data);
    }
    function win(){
        $data['template'] ='ajax/win-scene';
        $data['has_sidebar'] = 'has-menu';
        $data['lng'] = 'english';
        $this->lang->load($data['lng'], $data['lng']);
        $data['load_menu'] = true;
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }

    function lose(){
        $data['template'] ='ajax/lose-scene';
        $data['has_sidebar'] = 'has-menu';
        $data['lng'] = 'english';
        $this->lang->load($data['lng'], $data['lng']);
        $data['footer_url'] = $this->city->load_city(15);
        $data['load_menu'] = true;
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function donate($city,$answer){
        $data['template'] ='ajax/donate-scene';
        $data['has_sidebar'] = 'has-menu';
        $data['footer_url'] = $this->city->load_city($city);
        $data['answer'] = $this->question->get_answer($answer);
        $data['lng'] = 'english';
        $this->lang->load($data['lng'], $data['lng']);
        $data['load_menu'] = true;
        $data['body_class'] = "white-class";
        $this->load->view('frontend/template', $data);
    }
    function question($question){
        $data['question'] = $this->question->get_frontend($question);
        $data['template'] ='ajax/questions';
        $data['has_sidebar'] = 'has-menu';
        $data['lng'] = 'english';
        $this->lang->load($data['lng'], $data['lng']);
        $data['load_menu'] = true;
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function answer($answer){
        $data['answer'] = $this->question->get_answer($answer);
        $data['template'] ='ajax/answers';
        $data['lng'] = 'english';
        $this->lang->load($data['lng'], $data['lng']);
        $data['load_menu'] = true;
        $data['has_sidebar'] = 'has-menu';
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
}
