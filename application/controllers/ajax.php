<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $config['upload_path'] = 'uploads';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = '204800';
        $this->load->library('upload', $config);
        $this->load->model('city');
        $this->load->model('scenario');
        $this->load->model('question');
        $this->load->model('load_user');
        $this->load->model('grocery');
        $this->load->model('support');
        $this->load->model('f_emails');
        $this->load->library('user_agent');
        $this->load->model('stats');
    }

    public function do_upload(){
        $session_data = $this->session->userdata('logged_in');
        if(!$session_data){
            return false;
        }
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            foreach ($error as $item => $value) {
                echo $value;
            }
            exit;
        } else {
            $upload_data = array('upload_data' => $this->upload->data());
            foreach ($upload_data as $key => $value) {
                $image = $value['file_name'];
                $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value['file_name']);
            }
            echo $image;
        }
    }

    function get_filter(){
        $session_data = $this->session->userdata('logged_in');
        if(!$session_data){
            echo json_encode(array('status'=>401,'message'=>'You have to login if you want to use this API'));
            return false;
        }
        $session_data = $this->session->userdata('logged_in');
        if($session_data['account_type'] == 'admin'){
            $this->load->model('load_user');
            $user_info = $this->load_user->load_details($session_data['id'])[0];
            $city_id = $user_info->city;
        }else{
            $city_id = null;
        }
        echo $this->question->get_by_filter($_POST['filters'],$session_data['account_type'],$city_id);
    }
    function get_general_stats(){
        $session_data = $this->session->userdata('logged_in');
        if(!$session_data){
            echo json_encode(array('status'=>401,'message'=>'You have to login if you want to use this API'));
            return false;
        }
        if($session_data['account_type'] == 'superadmin'){
            $result = $this->stats->get_all_cities();
        }else{
            $city = $this->load_user->load_details($session_data['id'])[0];
            $result = $this->stats->get_city($city->city);
        }
        echo json_encode($result);
    }
    function get_play_per(){
        $session_data = $this->session->userdata('logged_in');
        if(!$session_data){
            echo json_encode(array('status'=>401,'message'=>'You have to login if you want to use this API'));
            return false;
        }
        if($session_data['account_type'] == 'superadmin'){
            $result = $this->stats->get_played_time($_POST);
        }else{
            $city = $this->load_user->load_details($session_data['id'])[0];
            $result = $this->stats->get_played_time_city($city->city,$_POST);
        }
        echo json_encode($result);
    }
    function get_city(){
        echo json_encode($this->city->load_city($_POST['id']));
    }

    function get_scenario_scene(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['scenarios'] = $this->scenario->get_all_by_city($_POST['id']);
        $data['footer_url'] = $this->city->load_city($_POST['id']);
        $data['lng'] = $lang;
        $content = array(
            'content' => $this->load->view('frontend/ajax/load-scenario', $data, true),
            'footer' => $this->load->view('frontend/footer',$data,true),
            'body' => 'dark-class',
            'menu' => false,
            'menu_content' =>$this->load->view('frontend/menu',$data,true),
            'menu_mobile'=> $this->load->view('frontend/menu-mobile',$data,true),
            'data' => $data['scenarios'],
            'city' => $data['footer_url']
        );
        echo json_encode($content);
    }

    function get_scenario(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['lng'] = $lang;
        $this->stats->update($_POST['stats']['id'],$_POST['stats']);
        $data['scenario'] = $this->scenario->get_single($_POST['scenario']);
        $data['city'] = $this->city->load_city($_POST['city']);
        $content = array(
            'content' => $this->load->view('frontend/ajax/load-single-scenario', $data, true),
            'body' => 'dark-class',
            'menu' => true
        );
        echo json_encode($content);
    }
    function get_rent(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['rent'] = $this->scenario->load_rent($_POST['scenario']);
        $data['lng'] = $lang;
        $content = array(
            'content' => $this->load->view('frontend/ajax/rent-scene', $data, true),
            'question_ids' => $this->question->get_ids($_POST['city'],$_POST['scenario'])
        );
        echo json_encode($content);
    }
    function get_question(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $this->stats->update($_POST['stats']['id'],$_POST['stats']);
        $data['question'] = $this->question->get_frontend($_POST['id']);
        $data['lng'] = $lang;
        $content = array(
            'content' => $this->load->view('frontend/ajax/questions', $data, true),
            'question' => $data['question'],
            'question_ids' =>$this->question->get_ids($_POST['city'],$_POST['scenario'],$_POST['not_id'])
        );
        echo json_encode($content);
    }
    function get_donate(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['footer_url'] = $this->city->load_city($_POST['city']);
        $data['answer'] = $this->question->get_answer($_POST['id']);
        $data['lng'] = $lang;
        $this->stats->update($_POST['stats']['id'],$_POST['stats']);
        $content = array(
            'content' => $this->load->view('frontend/ajax/donate-scene', $data, true),
            'body' => 'white-class'
        );
        echo json_encode($content);
    }
    function get_answer(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['answer'] = $this->question->get_answer($_POST['id']);
        $data['lng'] = $lang;
        $this->stats->update($_POST['stats']['id'],$_POST['stats']);
        $content = array(
            'content' => $this->load->view('frontend/ajax/answers', $data, true),
            'body' => 'dark-class',
            'question_ids' =>$this->question->get_ids($_POST['city'],$_POST['scenario'],$_POST['not_id'])
        );
        echo json_encode($content);
    }
    function get_win(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['footer_url'] = $this->city->load_city($_POST['city']);
        if(isset($_POST['end_con'])){
            $data['end_con'] = $_POST['end_con'];
        }
        $data['lng'] = $lang;
        $this->stats->update($_POST['stats']['id'],$_POST['stats']);
        $content = array(
            'content' => $this->load->view('frontend/ajax/win-scene', $data, true),
            'body' => 'white-class'
        );
        echo json_encode($content);
    }
    function get_lose(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $this->stats->update($_POST['stats']['id'],$_POST['stats']);
        $data['footer_url'] = $this->city->load_city($_POST['city']);
        if(isset($_POST['end_con'])){
            $data['end_con'] = $_POST['end_con'];
        }
        $data['lng'] = $lang;
        $content = array(
            'content' => $this->load->view('frontend/ajax/lose-scene', $data, true),
            'body' => 'white-class'
        );
        echo json_encode($content);
    }
    function get_privacy(){
        $document = $this->support->get(3);
        echo json_encode($document);
    }
    function get_about(){
        $document = $this->support->get(4);
        echo json_encode($document);
    }
    function get_email_template(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr' || $_POST['lang'] == 'french'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['lng'] = $lang;
        $content = array(
            'content' => $this->load->view('frontend/ajax/email-pop', $data, true),
            'title' =>  $this->lang->line('email-title')
        );
        echo json_encode($content);
    }
    function send_share(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr' || $_POST['lang'] == 'french'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['lng'] = $lang;
        if($this->f_emails->invite_users($_POST['name'],$_POST['email'],$_POST['info'],$_POST['daysx'])){
            $result = array(
                'title' => $this->lang->line('send-share-title')
            );
        }else{
            $result = array(
                'title' => "error"
            );
        }
        echo json_encode($result);
    }
    function get_take_action(){
        if(isset($_POST['lang']) && $_POST['lang'] == 'fr' || $_POST['lang'] == 'french'){
            $lang = 'french';
        }else{
            $lang = 'english';
        }
        $this->lang->load($lang, $lang);
        $data['footer_url'] = $this->city->load_city(@$_POST['city']);
        $content = array(
            'content' => $this->load->view('frontend/ajax/take-action', $data, true),
            'title' =>  $this->lang->line('take-action-title')
        );
        echo json_encode($content);
    }
}