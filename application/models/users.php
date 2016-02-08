<?php 
Class Users extends CI_Model{
    function get_all(){
        $query = $this->db->query('
            Select u.username,u.id,u.email,u.account_status, u.last_login, CASE WHEN ud.city IS NULL THEN "Master" ELSE c.name END as function
            from user_details ud
            LEFT join cities c on ud.city = c.id
            INNER JOIN user u on ud.user_id = u.id ');
        $query = $query->result();
        return $query;
    }
    function add_user($array){      
        $this->db->select('email');
        $this->db->from('user');
        $this->db->where('email',$array['email']);
        $email_test = $this->db->count_all_results();
        if($email_test>0){            
            return 'This email already exists, please choose another one!';
        }
        if($array['city'] == 'NULL'){
            $user_type = 'superadmin';
        }else{
            $user_type = 'admin';
        }
        $data = array(
            'username'=>$array['username'],
            'password'=>md5($array['password']),
            'email'=>$array['email'],
            'account_type'=>$user_type,
            'account_status'=>'active'
        );
        $this->db->insert('user',$data);
        $user_id = $this->db->insert_id();         
        $name = explode(' ',$array['name']);
        if(isset($name[1])){
            $last_name = $name[1];
        }else{
            $last_name = 'NULL';
        }
        $data = array(
            'first_name'=>$name[0],
            'last_name'=>$last_name,
            'phone_no'=>$array['phone'],
            'user_id'=>$user_id
        );
        if($array['city']!='NULL'){
            $data['city']=$array['city'];
        }
        if($this->db->insert('user_details',$data)){
            return 1;
        }else{
            return 'User '.$array['username'].' wasn\'t added! Try again!';
        }
    }
    function update_user($id,$array){      
        if($array['city'] == 'NULL'){
            $user_type = 'superadmin';
        }else{
            $user_type = 'admin';
        }
        $data = array(
            'username'=>$array['username'],
            'account_type'=>$user_type,
            'account_status'=>'active'
        );
        if($array['password']){
            $data['password'] = md5($array['password']);
        }
        $this->db->where('id',$id);
        $this->db->update('user',$data);         
        $name = explode(' ',$array['name']);
        if(isset($name[1])){
            $last_name = $name[1];
        }else{
            $last_name = 'NULL';
        }
        $data = array(
            'first_name'=>$name[0],
            'last_name'=>$last_name,
            'phone_no'=>$array['phone']
        );
        if($array['city']!='NULL'){
            $data['city']=$array['city'];
        }else{
            $data['city'] = NULL;
        }
        $this->db->where('user_id',$id);
        if($this->db->update('user_details',$data)){
            return 1;
        }else{
            return 'User '.$array['username'].' wasn\'t updated! Try again!';
        }
    }
    function delete_user($id){
        $this->db->select('id');
        $this->db->from('user');
        $this->db->where('id',$id);
        $exist = $this->db->count_all_results();
        if($exist>0){
            $this->db->delete('user_details',array('user_id'=>$id));
            if($this->db->delete('user',array('id'=>$id))){
                return 1;
            }else{
                return 'We can\'t delete this user... Try Again!';
            }
        
        }else{
            return 2;
        }
    }
    function get_info($id){
        $this->db->select('id');
        $this->db->from('user');
        $this->db->where('id',$id);
        $exist = $this->db->count_all_results();
        if($exist>0){
            $query = $this->db->select('*')->from('user u')->join('user_details ud','ud.user_id = u.id')->where('u.id',$id)->get()->result();
            return $query[0];
        }else{
            return 0;
        }
    }
    function save_message($message){
        $this->db->where('id',1);
        return $this->db->update('user_messages',array('content'=>$message));
    }
    function get_message(){
        $this->db->select('content');
        $this->db->from('user_messages');
        $this->db->where('id',1);
        $query = $this->db->get();
        $query = $query->result();
        return $query[0];
    }
}
?>