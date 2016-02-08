<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Superadmin extends CI_Controller {
    function __construct(){
       parent::__construct();
       $this->load->helper('url');
       $this->load->model('load_user');
       $this->load->model('users');
       $this->load->model('city');
       $this->load->model('scenario');
       $this->load->model('question');
       $this->load->model('grocery');
       $this->load->model('support');
       $this->load->model('stats');
       $session_data = $this->session->userdata('logged_in');
       if($session_data){        
        if($session_data['account_type']=='superadmin'){
         }else{
            redirect($session_data['account_type'], 'refresh');
         }
       }
       else{
         redirect('login', 'refresh');
       }
     }
     function _remap($method, $params = array()){
        if(method_exists($this, $method)){
            return call_user_func_array(array($this, $method), $params);
        }else{
            redirect('superadmin');
        }
     }
    function index(){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $data['template']="home";
        $data['stats'] = true;
        $data['messages'] = $this->users->get_message();
        $data['structure']="backend";
        $data['access']="superadmin";
        $this->load->view('template',$data);
    }
    function cities($city = NULL){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        if(is_null($city)){
            $data['cities'] = $this->city->get_all();
            $data['template']="cities";
        }elseif($city=='new-city'){
            $data['template']="city";
        }elseif($city=='change-status'){
            echo $this->city->change_status($_POST['id'],$_POST['status']);
            exit();
        }else{
            redirect('superadmin/cities');
        }
        $data['structure']="backend";
        $data['access']="superadmin";
        $this->load->view('template',$data);
    }
    function users($action = NULL,$id=NULL){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];        
        $data['messages'] = $this->users->get_message();
        if(is_null($action)){
            $data['template']="users";
            $data['users'] = $this->users->get_all();
        }elseif($action=='new'){
            $data['template']="new-user";
            $data['cities'] = $this->city->get_all();
            if(isset($_POST['add_user'])){
                $element = $_POST;
                unset($element['add_user']);
                $result = $this->users->add_user($element);
                if($result == 1){
                    $data['message'] = 'User '.$_POST['username'].' was added!';
                    $data['message_type']='done';
                }else{
                    $data['message'] = $result;
                    $data['message_type']='error';
                }
            }
        }elseif($action=='delete'){
            if(is_null($id)){
                redirect('superadmin/users');
            }else{
                $result = $this->users->delete_user($id);
                if($result == 1){
                    redirect('superadmin/users');
                }else{
                    $data['template']="users";
                    $data['users'] = $this->users->get_all();
                    $data['message'] = $result;
                    $data['message_type']='error';
                }
            }
        }elseif($action=='edit'){
            if(is_null($id)){
                redirect('superadmin/users');
            }else{
                $data['template']="edit-user";
                $data['cities'] = $this->city->get_all();
                $data['user'] = $this->users->get_info($id);
                if(isset($_POST['update_user'])){
                    $element = $_POST;
                    unset($element['update_user']);
                    $result = $this->users->update_user($id,$element);
                    if($result == 1){
                        $data['message'] = 'User '.$_POST['username'].' was updated!';
                        $data['message_type']='done';
                    }elseif($result == 2){
                        $data['template']="users";
                        $data['users'] = $this->users->get_all();
                        $data['message'] = 'This user doesn\' exist!';
                        $data['message_type']='error';
                    }else{
                        $data['message'] = $result;
                        $data['message_type']='error';
                    }
                }
            }
        }elseif($action == 'messages'){
            $data['template']="user-messages";
            if(isset($_POST['save-message'])){
                if($this->users->save_message($this->input->post('message'))){
                    $data['message'] = 'Message saved!';
                    $data['message_type']='done';
                }else{
                    $data['message'] = 'Message coudn\'t be save! Try again';
                    $data['message_type']='error';
                }
            }
        }else{
            redirect('superadmin/users');
        }
        $data['structure']="backend";
        $data['access']="superadmin";
        $this->load->view('template',$data);
    }
    function scenario($action = null, $id = null){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];        
        $data['messages'] = $this->users->get_message();
        if(is_null($action)){            
            $data['template']="scenarios";
            $data['scenarios'] = $this->scenario->get_all();
        }elseif($action=='edit'){
            if(is_null($id)){
                redirect('superadmin/scenario');
            }
            if(isset($_POST['update'])){
                $element = $_POST;
                unset($element['update']);
                $update = $this->scenario->update($id,$element);
                if($update){
                    $data['message'] = 'Scenario updated!';
                    $data['message_type']='done';
                }else{
                    $data['message'] = 'Scenario coudn\'t be updated! Try again';
                    $data['message_type']='error';
                }
            }
            $data['scenario'] = $this->scenario->get_single($id);
            $data['template']="update-scenario";
        }else{
            redirect('superadmin/scenario');
        }
        $data['structure']="backend";
        $data['access']="superadmin";
        $this->load->view('template',$data);
    }
    function custom_questions($action = NULL, $id = NULL, $page = 1){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $data['messages'] = $this->users->get_message();
        if(is_null($action) || ($action == 'page' && $id=='current')){
            $data['questions'] = $this->question->get_all_custom($page);
            $data['pages'] = $this->question->get_nr_pages_custom();
            $data['types'] = $this->scenario->get_all();
            $data['current_page'] = $page;
            $data['cities'] = $this->city->get_all();
            $data['template'] = 'questions-custom';
        }else{
            redirect('superadmin/custom-questions');
        }
        $data['structure']="backend";
        $data['access']="superadmin";
        $this->load->view('template',$data);
    }
    function questions($action = NULL, $id = NULL, $page = 1){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];        
        $data['messages'] = $this->users->get_message();
        if(is_null($action) || ($action == 'page' && $id=='current')){
            $data['questions'] = $this->question->get_all($page);
            $data['pages'] = $this->question->get_nr_pages();
            $data['types'] = $this->scenario->get_all();
            $data['current_page'] = $page;
            $data['cities'] = $this->city->get_all();
            $data['template'] = 'questions';
        }elseif($action == 'new'){
            $data['template'] = 'new-question';
            if(isset($_POST['add'])){
                $elemens = $_POST;
                unset($elemens['add']);
                $result = $this->question->add($elemens);
                $this->load->model('history');
                $this->history->add_history($id,$elemens,$session_data['id']);
                if($result){
                    redirect('superadmin/questions/edit/'.$result);
                }else{
                    $data['message'] = $result;
                    $data['message_type']='error';
                }
            }
            $data['cities'] = $this->city->get_all();
        }elseif($action == 'edit'){
            if(is_null($id)){
                redirect('superadmin/questions');
            }else{
                $this->load->model('history');
                $data['histories'] = $this->history->get_history($id);
                $data['template'] = 'edit-question';
                if(isset($_POST['edit'])){
                    $elemens = $_POST;
                    unset($elemens['edit']);
                    $result = $this->question->update($id,$elemens);
                    $this->history->add_history($id,$elemens,$session_data['id']);
                    if($result =='ok'){
                        $data['message'] = 'Question was updated!';
                        $data['message_type']='done';
                    }else{
                        $data['message'] = $result;
                        $data['message_type']='error';
                    }
                }
                $data['history'] = $this->history->get_history($id);
                $data['question_set'] = $this->question->get($id);
                $data['cities'] = $this->city->get_all();
            }
        }elseif($action == 'delete'){
            if(is_null($id)){
                redirect('superadmin/questions');
            }else{
                $result = $this->question->delete($id);
                if($result){
                    redirect('superadmin/questions');
                }else{
                    $data['message'] = $result;
                    $data['message_type']='error';
                }
            }
        }else{
            redirect('superadmin/questions');
        }
        $data['structure']="backend";
        $data['access']="superadmin";
        $this->load->view('template',$data);
    }
    function grocery(){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];  
        if(isset($_POST['update'])){
            $element = $_POST;
            unset($element['update']);
            $result = $this->grocery->update_master($element);
            if($result === true){
                $data['message'] = 'Grocery Scene was updated!';
                $data['message_type']='done';
            }else{
                $data['message'] = $result;
                $data['message_type']='error';
            }
        }
        $data['grocery_info'] = $this->grocery->load_master();   
        $data['template'] = 'grocery';   
        $data['messages'] = $this->users->get_message();
        $data['structure']="backend";
        $data['access']="superadmin";
        $this->load->view('template',$data);
    }
    function help($sup = null){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        if(is_null($sup)){
            if(isset($_POST['update'])){
                $result = $this->support->save($this->input->post(),1);
                if($result === true){
                    $data['message'] = 'Documentation was updated!';
                    $data['message_type']='done';
                }else{
                    $data['message'] = $result;
                    $data['message_type']='error';
                }
            }
            $data['documentation'] = $this->support->get(1);
            $data['template'] = 'support';
        }elseif($sup == "support"){
            if(isset($_POST['update'])){
                $result = $this->support->save($this->input->post(),2);
                if($result === true){
                    $data['message'] = 'Contact Us was updated!';
                    $data['message_type']='done';
                }else{
                    $data['message'] = $result;
                    $data['message_type']='error';
                }
            }
            $data['template'] = 'contact_us';
            $data['documentation'] = $this->support->get(2);
        }elseif($sup == "privacy"){
            if(isset($_POST['update'])){
                $result = $this->support->save($this->input->post(),3);
                if($result === true){
                    $data['message'] = 'Privacy content was updated!';
                    $data['message_type']='done';
                }else{
                    $data['message'] = $result;
                    $data['message_type']='error';
                }
            }
            $data['template'] = 'privacy';
            $data['documentation'] = $this->support->get(3);
        }elseif($sup == "about"){
            if(isset($_POST['update'])){
                $result = $this->support->save($this->input->post(),4);
                if($result === true){
                    $data['message'] = 'About us content was updated!';
                    $data['message_type']='done';
                }else{
                    $data['message'] = $result;
                    $data['message_type']='error';
                }
            }
            $data['template'] = 'about';
            $data['documentation'] = $this->support->get(4);
        }elseif($sup == "tutorial"){
            $data['template'] = 'tutorial';
        }else{
            $data['template']="loading";
        }
        $data['structure']="backend";
        $data['access']="superadmin";
        $this->load->view('template',$data);
    }
    function stats($sup = null){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        if(is_null($sup)){
            $data['template']="stats";
            $data['stats'] = true;
            $data['cities'] = $this->city->get_all();
            $data['messages'] = $this->users->get_message();
        }elseif($sup == "paths"){
            $data['cities'] = $this->city->get_all();
            $data['datepicker'] = $this->stats->start_end();
            $data['template']="download";
        }else{
            redirect('superadmin/stats');
        }
        $data['structure']="backend";
        $data['access']="superadmin";
        $this->load->view('template',$data);
    }
    function generate_json(){
        if(isset($_POST['export'])){
            $this->load->library('excel');
            $titles = array('No', 'City','Scenario','Rent','No Questions','Last Question ID', "Last Question Name",'Last Answer','Final');
            $elements = $_POST;
            unset($elements['export']);
            $array = $this->stats->download_track(null,$elements);
            $this->excel->make_from_array($titles, $array,"Statistics");
        }
    }
}
?>