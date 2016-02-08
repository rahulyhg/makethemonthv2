<?php 
Class Load_user extends CI_Model{
 function load_details($id){
    $result = $this->db->get_where('user_details',array('user_id'=>$id));
    return $result->result();
 }
}
?>