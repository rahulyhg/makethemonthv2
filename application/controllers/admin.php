<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
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
        if($session_data['account_type']=='admin'){
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
            redirect('admin');
        }
     }
    function index(){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $data['template']="home";
        $data['stats'] = true;
        $data['messages'] = $this->users->get_message();
        $data['city'] = $this->city->load_city($data['info']->city);
        $data['structure']="backend";
        $data['access']="admin";
        $this->load->view('template',$data);
    }
    function scenario($action = null, $id = null){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];        
        $data['messages'] = $this->users->get_message();
        $data['city'] = $this->city->load_city($data['info']->city);
        if(is_null($action)){            
            $data['template']="scenarios";
            $data['scenarios'] = $this->scenario->get_all_by_city($data['info']->city);
        }elseif($action=='edit'){
            if(is_null($id)){
                redirect('admin/scenario');
            }
            if(isset($_POST['update'])){
                $element = $_POST;
                unset($element['update']);
                $update = $this->scenario->update_local($id,$element,$data['info']->city);
                if($update === true){
                    $data['message'] = 'Scenario updated!';
                    $data['message_type']='done';
                }elseif($update>1){
                    redirect('admin/scenario/edit/'.$update);
                }else{
                    $data['message'] = 'Scenario coudn\'t be updated! Try again';
                    $data['message_type']='error';
                }
            }
            $data['scenario'] = $this->scenario->get_single($id);
            $data['template']="update-scenario";
        }else{
            redirect('admin/scenario');
        }
        $data['structure']="backend";
        $data['access']="admin";
        $this->load->view('template',$data);
    }
    function custom_questions($action = NULL, $id = NULL, $page = 1){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $data['city'] = $this->city->load_city($data['info']->city);
        $data['messages'] = $this->users->get_message();
        if(is_null($action) || ($action == 'page' && $id=='current')){
            $data['questions'] = $this->question->get_local_custom($data['info']->city,$page);
            $data['pages'] = $this->question->get_nr_pages_local_custom($data['info']->city);
            $data['types'] = $this->scenario->get_all();
            $data['current_page'] = $page;
            $data['template'] = 'questions-custom';
        }elseif($action == 'delete'){
            if(is_null($id)){
                redirect('admin/custom-questions');
            }else{
                $result = $this->question->delete_local($id);
                if($result){
                    redirect('admin/custom-questions');
                }else{
                    $data['message'] = $result;
                    $data['message_type']='error';
                }
            }
        }else{
            redirect('admin/custom-question');
        }
        $data['structure']="backend";
        $data['access']="admin";
        $this->load->view('template',$data);
    }
    function generate_excel(){
        $this->load->library('excel');
        $this->load->model('export');
        $session_data = $this->session->userdata('logged_in');
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $titles = array('Field', 'Value');
        $array = $this->export->get_questions($data['info']->city);
        $this->excel->make_from_array($titles, $array);
    }
    function questions($action = NULL, $id = NULL, $page = 1){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $data['city'] = $this->city->load_city($data['info']->city);
        $data['messages'] = $this->users->get_message();
        if(is_null($action) || ($action == 'page' && $id=='current')){
            $data['questions'] = $this->question->get_local($data['info']->city,$page);
            $data['pages'] = $this->question->get_nr_pages_local($data['info']->city);
            $data['types'] = $this->scenario->get_all();
            $data['current_page'] = $page;
            $data['template'] = 'questions';
        }elseif($action == 'edit'){
            $this->load->model('history');
            if(is_null($id)){
                redirect('admin/questions');
            }else{
                if($this->question->check_if($id,$data['info']->city)){
                    redirect('admin/questions');
                }
                $data['template'] = 'edit-question';
                if(isset($_POST['edit'])){
                $elemens = $_POST;
                unset($elemens['edit']);
                $result = $this->question->update_local($id,$elemens,$data['info']->city);
                $this->history->add_history($id,$elemens,$session_data['id']);
                if($result =='ok'){
                    $data['message'] = 'Question was updated!';
                    $data['message_type']='done';
                }elseif(is_numeric($result)){
                    redirect('admin/questions/edit/'.$result);
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
                redirect('admin/questions');
            }else{
                $result = $this->question->delete_local($id);
                if($result){
                    redirect('admin/questions');
                }else{
                    $data['message'] = $result;
                    $data['message_type']='error';
                }
            }
        }else{
            redirect('admin/questions');
        }
        $data['structure']="backend";
        $data['access']="admin";
        $this->load->view('template',$data);
    }
    function grocery(){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $data['city'] = $this->city->load_city($data['info']->city);
        if(isset($_POST['update'])){
            $element = $_POST;
            unset($element['update']);
            $result = $this->grocery->update_local($data['info']->city,$element);
            if($result === true){
                $data['message'] = 'Grocery Scene was updated!';
                $data['message_type']='done';
            }else{
                $data['message'] = $result;
                $data['message_type']='error';
            }
        }
        $data['grocery_info'] = $this->grocery->load_local($data['info']->city);   
        $data['template'] = 'grocery';   
        $data['messages'] = $this->users->get_message();
        $data['structure']="backend";
        $data['access']="admin";
        $this->load->view('template',$data);
    }
    function rent(){
        $session_data = $this->session->userdata('logged_in');
        $this->load->model('rent');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $data['city'] = $this->city->load_city($data['info']->city);
        if(isset($_POST['update'])){
            $element = $_POST;
            unset($element['update']);
            $result = $this->rent->update_local($data['info']->city,$element);
            if($result === true){
                $data['message'] = 'Rent for '.$data['city']->name.' was updated!';
                $data['message_type']='done';
            }else{
                $data['message'] = $result;
                $data['message_type']='error';
            }
        }
        $data['rent']=$this->rent->load_rent($data['info']->city);
        $data['template']="rent";
        $data['structure']="backend";
        $data['access']="admin";
        $this->load->view('template',$data);
    }
    function setup(){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $data['city'] = $this->city->load_city($data['info']->city);
        $data['messages'] = $this->users->get_message();
        if(isset($_POST['update'])){
            $element = $_POST;
            unset($element['update']);
            $result = $this->city->update_local($data['info']->city,$element);
            if($result === true){
                $data['message'] = 'City information was updated!';
                $data['message_type']='done';
            }else{
                $data['message'] = $result;
                $data['message_type']='error';
            }
        }
        $data['city'] = $this->city->load_city($data['info']->city);
        $data['template']="setup";
        $data['structure']="backend";
        $data['access']="admin";
        $this->load->view('template',$data);
    }
    function help($sup = null){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $data['city'] = $this->city->load_city($data['info']->city);
        if(is_null($sup)){
            $data['template'] = 'support';
            $data['documentation'] = $this->support->get(1);
        }elseif($sup == "support"){
            $data['template'] = 'contact_us';
            $data['documentation'] = $this->support->get(2);
        }elseif($sup == "privacy"){
            $data['template'] = 'privacy';
            $data['documentation'] = $this->support->get(3);
        }elseif($sup == "about"){
            $data['template'] = 'about';
            $data['documentation'] = $this->support->get(4);
        }elseif($sup == "tutorial"){
            $data['template'] = 'tutorial';
        }else{
            $data['template']="loading";
        }
        $data['structure']="backend";
        $data['access']="admin";
        $this->load->view('template',$data);
    }
    function stats($sup = null){
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['info'] = $this->load_user->load_details($session_data['id'])[0];
        $data['city'] = $this->city->load_city($data['info']->city);
        if(is_null($sup)){
            $data['template']="stats";
            $data['stats'] = true;
        }elseif($sup == "paths"){
            $data['cities'] = $this->city->get_all();
            $data['datepicker'] = $this->stats->start_end($data['info']->city);
            $data['template']="download";
        }else{
            redirect('superadmin/stats');
        }
        $data['structure']="backend";
        $data['access']="admin";
        $this->load->view('template',$data);
    }
    function generate_json(){
        $session_data = $this->session->userdata('logged_in');
        $city = $this->load_user->load_details($session_data['id'])[0];
        if(isset($_POST['export'])){
            $this->load->library('excel');
            $titles = array('No', 'City','Scenario','Rent','No Questions','Last Question ID', "Last Question Name",'Last Answer','Final');
            $elements = $_POST;
            unset($elements['export']);
            $array = $this->stats->download_track($city->city,$elements);
            $this->excel->make_from_array($titles, $array,"Statistics");
        }
    }
}
?>