<?php 
Class Rent extends CI_Model{
    function load_rent($city){
        $rent = $this->db->get_where('rent',array('city'=>$city))->result();
        if(empty($rent)){
            $rent = $this->db->select('*')->from('rent')->where('city is null')->get()->result();
        }
        $rent = $rent[0];
        return $rent;
    }
    function update_local($city,$array){
        $data = array(
            'max_rent'=>$array['max-rent'],
            'min_rent'=>$array['min-rent']
        );
        $rent = $this->db->get_where('rent',array('city'=>$city))->result();
        if(empty($rent)){
            $data['city']=$city;
            $this->db->insert('rent',$data);
        }else{
            $this->db->where('city',$city);
            $this->db->update('rent',$data);
        }
        return true;
    }
}
?>