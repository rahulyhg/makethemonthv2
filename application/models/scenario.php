<?php 
Class Scenario extends CI_Model{
    function get_all(){
        $this->db->from('scenario');
        $this->db->where('city is null');
        return $this->db->get()->result();
    }
    function get_single($id){
        return $this->db->get_where('scenario',array('id'=>$id))->result();
    }
    function update($id,$data){
        $this->db->where('id',$id);
        $this->db->update('scenario',$data);
        unset($data['start_up']);
        unset($data['salary']);
        $this->db->where('parent',$id);
        $this->db->update('scenario',$data);
        return true;
    }
    function get_all_by_city($id_city){
        $data = array();
        $this->db->select('en_name,id');
        $this->db->from('scenario');        
        $this->db->where('city is null');
        $scenarios = $this->db->get()->result();
        foreach($scenarios as $scenario){
            $this->db->select('*');
            $this->db->from('scenario');
            $this->db->where('city',$id_city);
            $this->db->where('en_name',$scenario->en_name);
            $info = $this->db->get()->result();
            if(empty($info)){
                $this->db->select('*');
                $this->db->from('scenario');
                $this->db->where('id',$scenario->id);
                $info = $this->db->get()->result();
            }
            $data[]=$info[0];
        }
        return $data;
    }
    function update_local($id, $info,$city){
        $this->db->from('scenario');
        $this->db->where('city',$city);
        $this->db->where('id',$id);
        $check = $this->db->count_all_results();
        if($check == 1){
            $data = array(
                'en_rent_paragraph'=>$info['en_rent_paragraph'],
                'fr_rent_paragraph'=>$info['fr_rent_paragraph'],
                'start_up'=>$info['start_up'],
                'salary'=>$info['salary'],
                'min_rent'=>$info['min-rent'],
                'max_rent'=>$info['max-rent']
            );
            $this->db->where('id',$id);
            $this->db->update('scenario',$data);
            return true;
        }elseif($check==0){
            $data = array(
                'en_name'=>$info['en_name'],
                'fr_name'=>$info['fr_name'],
                'icon_1'=>$info['icon_1'],
                'icon_2'=>$info['icon_2'],
                'city'=>$city,
                'start_up'=>$info['start_up'],
                'salary'=>$info['salary'],
                'en_paragraph'=>$info['en_paragraph'],
                'fr_paragraph'=>$info['fr_paragraph'],
                'en_rent_paragraph'=>$info['en_rent_paragraph'],
                'fr_rent_paragraph'=>$info['fr_rent_paragraph'],
                'min_rent'=>$info['min-rent'],
                'max_rent'=>$info['max-rent'],
                'parent'=> $id
            );
            $this->db->insert('scenario',$data);
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    function load_rent($id){
        $rent = $this->db->select('min_rent, max_rent,en_rent_paragraph,fr_rent_paragraph')->from('scenario')->where('id',$id)->get()->result();
        return $rent[0];
    }
}
?>