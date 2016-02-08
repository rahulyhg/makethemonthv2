<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('city');
        $this->load->model('scenario');
        $this->load->model('question');
        $this->load->model('grocery');
        $this->load->model('rent');
        $this->load->library('user_agent');
        $this->load->model('f_emails');
        $this->load->model('stats');
    }

    function _remap($method, $params = array()){
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            redirect('');
        }
    }

    function index(){
        $data['body_class'] = "dark-class";
        if($this->agent->is_browser()){
            $version = explode('.',$this->agent->version());
            $version = $version[0];
            $upgrade = false;
            $upgrade_url = "";
            switch($this->agent->browser()){
                case "Chrome":
                    if($version<21){
                        $upgrade = true;
                        $upgrade_url = "https://www.google.com/chrome/browser/desktop/index.html";
                    }
                    break;
                case "Opera":
                    if($version<10){
                        $upgrade = true;
                        $upgrade_url = "http://www.opera.com/computer/windows";
                    }
                    break;
                case "Internet Explorer":
                    if($version ==7 || $version == 8){
                        $upgrade = true;
                        $upgrade_url = "https://www.microsoft.com/en-us/download/internet-explorer-11-for-windows-7-details.aspx";
                    }
                    break;
                case "Safari":
                    if($version<4){
                        $upgrade = true;
                        $upgrade_url = "http://www.techspot.com/downloads/downloadnow/4184/?evp=d66201443c0260bd9879ca8854662387&file=1";
                    }
                    break;
                case "Mozilla":
                    if($version<16){
                        $upgrade = true;
                        $upgrade_url = "https://www.mozilla.org/en-US/firefox/new/";
                    }
                    if($version == 5){
                        $upgrade = false;
                    }
                    break;
                case "Firefox":
                    if($version<16){
                        $upgrade = true;
                        $upgrade_url = "https://www.mozilla.org/en-US/firefox/new/";
                    }
                    if($version == 5){
                        $upgrade = false;
                    }
                    break;
            }
            if($upgrade){
                $data['url'] = $upgrade_url;
                $data['template'] = "upgrade-browser";
                $this->load->view('frontend/template', $data);
                return false;
            }
        }
        $sesion_language = $this->session->userdata('local_language');
        if(!isset($sesion_language))
        {
            $this->session->set_userdata("local_language","english");
        }
        $data['lang'] = $this->session->userdata('local_language');
        if(isset($data['lang']) && $data['lang'] == 'french'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $data['noAction'] = 'hide';
        $this->lang->load($lang, $lang);
        $data['template'] = "home";
        $data['cities'] = $this->city->get_all();
        $this->load->view('frontend/template', $data);
    }
    function french(){
        $this->session->set_userdata("local_language","french");
        redirect('');
    }
    function english(){
        $this->session->set_userdata("local_language","english");
        redirect('');
    }
    function cities($city){
        if($this->agent->is_browser()){
            $version = explode('.',$this->agent->version());
            $version = $version[0];
            $upgrade = false;
            $upgrade_url = "";
            switch($this->agent->browser()){
                case "Chrome":
                    if($version<21){
                        $upgrade = true;
                        $upgrade_url = "https://www.google.com/chrome/browser/desktop/index.html";
                    }
                    break;
                case "Opera":
                    if($version<10){
                        $upgrade = true;
                        $upgrade_url = "http://www.opera.com/computer/windows";
                    }
                    break;
                case "Internet Explorer":
                    if($version == 7 || $version == 8){
                        $upgrade = true;
                        $upgrade_url = "https://www.microsoft.com/en-us/download/internet-explorer-11-for-windows-7-details.aspx";
                    }
                    break;
                case "Safari":
                    if($version<4){
                        $upgrade = true;
                        $upgrade_url = "http://www.techspot.com/downloads/downloadnow/4184/?evp=d66201443c0260bd9879ca8854662387&file=1";
                    }
                    break;
                case "Mozilla":
                    if($version<16){
                        $upgrade = true;
                        $upgrade_url = "https://www.mozilla.org/en-US/firefox/new/";
                    }
                    break;
                case "Firefox":
                    if($version<16){
                        $upgrade = true;
                        $upgrade_url = "https://www.mozilla.org/en-US/firefox/new/";
                    }
                    break;
            }
            if($upgrade){
                $data['url'] = $upgrade_url;
                $data['template'] = "upgrade-browser";
                $this->load->view('frontend/template', $data);
                return false;
            }
        }
        $data['lang'] = $this->session->userdata('local_language');
        if(isset($data['lang']) && $data['lang'] == 'french'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['template'] = "city-template";
        $data['city_info'] = $this->city->load_city($city);
        if($data['city_info']->status == 0){
            redirect('');
        }
        $playerId = $this->stats->create($city);
        $data['playerId'] = $playerId;
        $this->session->set_userdata("local_player",$playerId);
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function not_found(){
        $data['template'] = "not-found";
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function scenarios(){
        $data['template'] ='ajax/load-scenario';
        $data['scenarios'] = $this->scenario->get_all_by_city(1);
        $data['footer_url'] = $this->city->load_city(1);
        $data['has_sidebar'] = false;
        $data['lng'] = 'french';
        $this->lang->load($data['lng'], $data['lng']);
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function scenario(){
        $data['template'] ='ajax/load-single-scenario';
        $data['scenario'] = $this->scenario->get_single(1);
        $data['city'] = $this->city->load_city(1);
        $data['has_sidebar'] = 'has-menu';
        $data['lng'] = 'french';
        $this->lang->load($data['lng'], $data['lng']);
        $data['load_menu'] = true;
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function rent(){
        $data['template'] ='ajax/rent-scene';
        $data['rent'] = $this->scenario->load_rent(1);
        $data['has_sidebar'] = 'has-menu';
        $data['lng'] = 'french';
        $this->lang->load($data['lng'], $data['lng']);
        $data['body_class'] = "dark-class";
        $data['load_menu'] = true;
        $this->load->view('frontend/template', $data);
    }
    function win(){
        $data['template'] ='ajax/win-scene';
        $data['has_sidebar'] = 'has-menu';
        $data['lng'] = 'french';
        $this->lang->load($data['lng'], $data['lng']);
        $data['load_menu'] = true;
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }

    function lose(){
        $data['template'] ='ajax/lose-scene';
        $data['has_sidebar'] = 'has-menu';
        $data['lng'] = 'french';
        $this->lang->load($data['lng'], $data['lng']);
        $data['footer_url'] = $this->city->load_city(15);
        $data['load_menu'] = true;
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function donate(){
        $data['template'] ='ajax/donate-scene';
        $data['has_sidebar'] = 'has-menu';
        $data['footer_url'] = $this->city->load_city(15);
        $data['answer'] = $this->question->get_answer(21);
        $data['lng'] = 'french';
        $this->lang->load($data['lng'], $data['lng']);
        $data['load_menu'] = true;
        $data['body_class'] = "white-class";
        $this->load->view('frontend/template', $data);
    }
    function test_question(){
        $data['question'] = $this->question->get_frontend(187);
        $data['template'] ='ajax/questions';
        $data['has_sidebar'] = 'has-menu';
        $data['lng'] = 'french';
        $this->lang->load($data['lng'], $data['lng']);
        $data['load_menu'] = true;
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function test_answer(){
        $data['answer'] = $this->question->get_answer(1715);
        $data['template'] ='ajax/answers';
        $data['lng'] = 'french';
        $this->lang->load($data['lng'], $data['lng']);
        $data['load_menu'] = true;
        $data['has_sidebar'] = 'has-menu';
        $data['body_class'] = "dark-class";
        $this->load->view('frontend/template', $data);
    }
    function share($token){
        $this->f_emails->check_user($token);
        redirect('');
    }
}
