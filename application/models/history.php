<?php 
Class History extends CI_Model{
    function get_history($id){
        $this->db->select('h.changes, h.add_on, u.first_name,u.last_name, u.city');
        $this->db->from('history h');
        $this->db->join('user_details u','u.id = h.id_user');
        $this->db->join('question q','h.id_question = q.id');
        $this->db->where('h.id_question',$id);
        $this->db->or_where('q.id = (SELECT parent FROM question where id = '.$id.')');
        $this->db->order_by('h.id','Desc');
        $this->db->limit(1);
        $histories = $this->db->get()->result();
        if(!empty($histories)){
            $data = array();
            foreach($histories as $history){
                $history->changes = json_decode($history->changes);
                $data[] = $history;
            }
            return $data;
        }else{
            return false;
        }
    }
    function add_history($id,$array,$user){
        $data = array(
            'id_question'=>$id,
            'id_user'=>$user,
            'changes' =>json_encode($array)
        );
        $this->db->insert('history',$data);
    }
}
?>