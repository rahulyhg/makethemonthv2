<?php 
Class Support extends CI_Model{
    function save($attr,$id){
        $data = array(
            'document'=>$attr['documentation'],
            'fr_document'=>$attr['fr_documentation']
        );
        $this->db->where(array('id'=>$id));
        if($this->db->update('support',$data)){
            return true;
        }
    }
    function get($id){
        return $this->db->get_where('support',array('id'=>$id))->result()[0];
    }
}
?>