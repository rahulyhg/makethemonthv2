<?php 
Class User extends CI_Model{
 function login($username, $password)
 {
   $this -> db -> select('id, username, password,account_type');
   $this -> db -> from('user');
   $this -> db -> where('username', $username);
   $this -> db -> where('password', MD5($password));
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
     $result=$query->result();
     $this->load->helper('date');
     $datestring = "%Y-%m-%d %h:%i:%s";
     $time = time();
     $last=array('ip'=>$this->input->ip_address(),'last_login'=>date('Y-m-d h:m:s'));
     $this->db->where('id',$result[0]->id);
     $this->db->update('user',$last);
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 function load_user($id){
     /*$CI =& get_instance();
     $CI->load->model('user','user',true);*/
 }
}
?>